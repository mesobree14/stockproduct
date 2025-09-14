class AddImage extends HTMLElement {
  constructor() {
    super();
  }
  get count() {
    return this.getAttribute("count");
  }
  get names() {
    return this.getAttribute("names");
  }
  get defaultbtn() {
    return this.getAttribute("setdefault");
  }
  get custom() {
    return this.getAttribute("custom");
  }
  get filenames() {
    return this.getAttribute("filenames");
  }
  get wrapper() {
    return this.getAttribute("wrapper");
  }
  get cancle() {
    return this.getAttribute("cancles");
  }
  connectedCallback() {
    this.renderImage();
    this.setImagePriviews();
  }
  setImagePriviews() {
    let setwrapper = document.querySelector(`.${this.wrapper}`);
    let setImgName = document.querySelector(`.${this.filenames}`);
    let setBtncancle = document.querySelector(`.${this.cancle}`);
    let typeImg = document.querySelector(`.${this.id}`);
    let defaultInput = document.querySelector(`.${this.defaultbtn}`);
    let CustomButton = document.querySelector(`#${this.custom}`);
    let setExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

    CustomButton.onclick = function () {
      defaultInput.click();
    };
    defaultInput.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function () {
          const result = reader.result;
          typeImg.src = result;
          setwrapper.classList.add("active");
        };
        setBtncancle.addEventListener("click", function () {
          typeImg.src = "";
          setwrapper.classList.remove("active");
        });
        reader.readAsDataURL(file);
      }
      if (this.value) {
        let valueStore = this.value.match(setExp);
        setImgName.textContent = valueStore;
      }
    });
  }
  renderImage() {
    this.innerHTML = `
              <div class="container">
                  <div class="wrapper ${this.wrapper}">
                      <div class="image">
                         <img src="" alt="" class="${this.id}"> 
                      </div>
                      <div class="content">
                          <div class="icon">
                              <i class="fas fa-cloud-upload-alt"></i>
                          </div>
                          <div class="text">${this.names}</div>
                      </div>
                      <div class="btnCancle ${this.cancle}">
                          <i class="fas fa-times"></i>
                      </div>
                      <div class="file-name ${this.filenames}">File name hear</div>
                  </div>
                  <input type="file" name="${this.count}" class="${this.defaultbtn}" hidden>
                  <p class="BtnCustom" id="${this.custom}">อัพโหลดไฟล์</p> 
              </div>
          `;
  }
}

customElements.define("mian-add-image", AddImage);

let data = [];
const originalPush = data.push;

function createGrandTotal() {
  const results = document.querySelectorAll("span[id^='price_result-']");
  const resutlProduct = document.querySelectorAll("span[id^='is_totals-']");
  let totalOrder = results.length;
  document.getElementById("totalOrder").textContent = `${totalOrder} รายการ`;

  let totalPrice = 0;
  results.forEach((span) => {
    const value = parseFloat(span.textContent.trim()) || 0;
    totalPrice += value;
  });

  let totalCount = 0;
  resutlProduct.forEach((span) => {
    const value = parseFloat(span.textContent.trim()) || 0;
    totalCount += value;
  });
  document.getElementById("totalProducts").textContent = `${totalCount} ชิ้น`;
  document.getElementById("totalPrice").textContent = totalPrice;
  document.getElementById("is_totalprice").value = totalPrice;
  let counts = document.getElementById("count_totalpays");
  counts.value = totalPrice;
  let count_stuck = document.getElementById("count_stuck");

  let result = document.getElementById("results");
  counts.addEventListener("input", () => {
    result.classList.add("text-danger");
    let re_price = Number(totalPrice) - Number(counts.value);
    result.textContent = `  ${re_price} บาท`;
    count_stuck.value = re_price;
  });
}

class formOrDerSell extends HTMLElement {
  constructor() {
    super();
  }

  static get observedAttributes() {
    return ["numbers"];
  }
  get numbers() {
    return this.getAttribute("numbers");
  }
  input_prodcutname = "";
  input_cutommer = "";
  stockdata = [];
  type_price = 0;
  async connectedCallback() {
    await this.loadDataStock();
    this.renderCreateOrderSell();
    this.loadOption();
    this.updateData();
    this.scriptjs();
    this.isSelectPrice();
    this.removeform();
    this.valueDataProduct();
  }

  async loadDataStock() {
    try {
      const get_api_stock = await fetch(
        "http://localhost/stockproduct/system/backend/api/stock.php",
        {
          method: "GET",
          credentials: "include",
        }
      );
      const response = await get_api_stock.json();
      this.stockdata.push(...response.data);
      return response.data;
    } catch (e) {
      throw new Error(`Fetch Stock Is Error : ${e}`);
    }
  }

  isSelectPrice(productname, customer) {
    const price_customer_frontstores = this.querySelector(
      `#price_customer_frontstore-${this.numbers}`
    );
    const price_custommer_vips = this.querySelector(
      `#price_custommer_vip-${this.numbers}`
    );
    const price_customer_dealers = this.querySelector(
      `#price_customer_dealer-${this.numbers}`
    );
    const price_customer_delivers = this.querySelector(
      `#price_customer_deliver-${this.numbers}`
    );

    const frontstore_price = this.querySelector(
      `#frontstore_price-${this.numbers}`
    );
    const vip_price = this.querySelector(`#vip_price-${this.numbers}`);
    const dealer_price = this.querySelector(`#dealer_price-${this.numbers}`);
    const deliver_price = this.querySelector(`#deliver_price-${this.numbers}`);

    const tatolproduct = this.querySelector(`#tatolproduct-${this.numbers}`);
    const res_price = this.querySelector(`#is_count-${this.numbers}`);
    const is_totals = this.querySelector(`#is_totals-${this.numbers}`);
    const price_result = this.querySelector(`#price_result-${this.numbers}`);
    const distotal = this.querySelector(".distotal");
    const dropdown = this.querySelector(`.dropdown-${this.numbers}`);
    const selectSpan = dropdown.querySelector(`.select-${this.numbers} span`);
    let input_result = this.querySelector(`#resutl_${this.numbers}`);
    distotal.disabled = true;
    if (!productname) {
      console.log("not data");
      return;
    }
    const filtered = this.stockdata.filter((item) =>
      item.product_name.includes(productname)
    );

    if (filtered[0].price_customer_frontstore) {
      frontstore_price.innerHTML = `ชิ้นละ ${filtered[0].price_customer_frontstore} บาท`;
      price_customer_frontstores.classList.remove("disabledLi");
    } else {
      frontstore_price.innerHTML = "";
      price_customer_frontstores.classList.add("disabledLi");
      selectSpan.innerText = "เลือก เรทราคา";
      res_price.innerHTML = "";
      price_result.innerHTML = "";
    }
    if (filtered[0].price_custommer_vip) {
      vip_price.innerHTML = `ชิ้นละ ${filtered[0].price_custommer_vip} บาท`;
      price_custommer_vips.classList.remove("disabledLi");
    } else {
      vip_price.innerHTML = "";
      price_custommer_vips.classList.add("disabledLi");
      selectSpan.innerText = "เลือก เรทราคา";
      res_price.innerHTML = "";
      price_result.innerHTML = "";
    }
    if (filtered[0].price_customer_dealer) {
      dealer_price.innerHTML = `ชิ้นละ ${filtered[0].price_customer_dealer} บาท`;
      price_customer_dealers.classList.remove("disabledLi");
    } else {
      price_customer_dealers.classList.add("disabledLi");
      dealer_price.innerHTML = "";
      selectSpan.innerText = "เลือก เรทราคา";
      res_price.innerHTML = "";
      price_result.innerHTML = "";
    }
    if (filtered[0].price_customer_deliver) {
      deliver_price.innerHTML = `ชิ้นละ ${filtered[0].price_customer_deliver} บาท`;
      price_customer_delivers.classList.remove("disabledLi");
    } else {
      deliver_price.innerHTML = "";
      price_customer_delivers.classList.add("disabledLi");
      selectSpan.innerText = "เลือก เรทราคา";
      res_price.innerHTML = "";
      price_result.innerHTML = "";
    }
    if (productname && customer) {
      this.type_price = filtered[0][customer.replace(/-\d+$/, "")];
      res_price.innerHTML = filtered[0][customer.replace(/-\d+$/, "")];
      distotal.disabled = false;

      let response =
        Number(is_totals.innerHTML) *
        Number(filtered[0][customer.replace(/-\d+$/, "")]);
      price_result.innerHTML = response;
      price_result.textContent = response;
      input_result.value = response;
      createGrandTotal();
      tatolproduct.addEventListener("input", function () {
        is_totals.textContent = this.value;
        let result =
          Number(this.value) *
          Number(filtered[0][customer.replace(/-\d+$/, "")]);
        price_result.innerHTML = result;
        price_result.textContent = result;
        input_result.value = result;
        this.dispatchEvent(new CustomEvent("update", { bubbles: true }));
        createGrandTotal();
      });
    }
  }

  updateData(data) {
    let selectedData = document.querySelector(`.selectedData-${this.numbers}`);
    let customInputContainer = document.querySelector(
      `.customInputContainer-${this.numbers}`
    );
    const ul = document.querySelector("ul");
    const dropdown = this.querySelector(`.dropdown-${this.numbers}`);
    if (data) {
      dropdown.classList.remove("disableds");
      this.isSelectPrice(data, this.type_price);
    } else {
      dropdown.classList.add("disableds");
    }

    selectedData.value = data ?? "";

    for (const li of document.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find((li) => li.innerText === data);
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }

  loadOption() {
    const tatolproducts = this.querySelector(`#tatolproduct-${this.numbers}`);
    let customInput = document.querySelector(`.customInput-${this.numbers}`);
    let selectedData = document.querySelector(`.selectedData-${this.numbers}`);
    let searchInput = document.querySelector(
      `.searchInput-${this.numbers} input`
    );
    const dropdown = this.querySelector(`.dropdown-${this.numbers}`);
    let ul = document.querySelector(`.options-${this.numbers} ul`);
    let customInputContainer = document.querySelector(
      `.customInputContainer-${this.numbers}`
    );
    window.addEventListener("click", (e) => {
      const searchInputEl = document.querySelector(
        `.searchInput-${this.numbers}`
      );
      if (searchInputEl && searchInputEl.contains(e.target)) {
        searchInputEl.classList.add("focus");
      } else if (searchInputEl) {
        searchInputEl.classList.remove("focus");
      }
      if (customInputContainer && !customInputContainer.contains(e.target)) {
        customInputContainer.classList.remove("show");
      }
    });

    customInput.addEventListener("click", () => {
      customInputContainer.classList.toggle("show");
    });

    let productLength = this.stockdata.length;

    for (let i = 0; i < productLength; i++) {
      let products = this.stockdata[i];
      tatolproducts.min = 0;
      const li = document.createElement("li");
      li.classList.add("block");
      const row = document.createElement("div");
      row.classList.add("row");
      let span = document.createElement("span");
      let small = document.createElement("small");
      if (products.remaining_product <= 0) {
        li.classList.add("disabled");
        li.style.pointerEvents = "none";
        li.style.color = "gray";
        li.style.opacity = "0.6";
      }

      span.textContent = products.product_name;
      if (products.remaining_product == 0) {
        small.textContent = "สินค้าหมด";
      } else if (products.remaining_product < 0) {
        small.textContent = `สินค้าติดลบ ${products.remaining_product}`;
      } else {
        small.textContent = `เหลืออีก ${products.remaining_product} ชิ้น`;
      }
      small.classList.add("ml-auto");
      row.appendChild(span);
      row.appendChild(small);
      li.appendChild(row);
      ul.appendChild(li);
    }

    ul.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", (e) => {
        let spanTxt = li.querySelector("span").innerText;
        selectedData.value = spanTxt;

        for (const li of document.querySelectorAll("li.selected")) {
          li.classList.remove("selected");
        }
        li.classList.add("selected");
        customInputContainer.classList.toggle("show");
      });
    });
    searchInput.addEventListener("keyup", (e) => {
      let searchedVal = searchInput.value.toLowerCase();
      let searched_product = this.stockdata.filter((data) =>
        data.product_name.toLowerCase().includes(searchedVal)
      );

      ul.innerHTML = "";
      if (searched_product.length === 0) {
        dropdown.classList.add("disableds");
        ul.innerHTML = `<p style='margin-top: 1rem;'>
                          ไม่มีข้อมูล
                        </p>`;
        return;
      }
      searched_product.forEach((product) => {
        const li = document.createElement("li");
        li.textContent = product.product_name;
        this.input_prodcutname = product.product_name;

        li.addEventListener("click", (e) => {
          this.input_prodcutname = e.target.textContent;
          this.updateData(e.target.textContent);
        });
        ul.appendChild(li);
      });
    });
  }
  scriptjs() {
    const dropdown = this.querySelector(`.dropdown-${this.numbers}`);
    const dropdownMenu = dropdown.querySelector(
      `.dropdown-menu-${this.numbers}`
    );

    let ul = document.querySelector(`.options-${this.numbers} ul`);

    dropdown.classList.add("disableds");

    ul.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", (e) => {
        let spanTxt = li.querySelector("span").innerText;
        this.input_prodcutname = spanTxt;
        if (spanTxt === "") {
          dropdown.classList.add("disableds");
        } else {
          dropdown.classList.remove("disableds");
        }
        this.isSelectPrice(this.input_prodcutname, this.input_cutommer);
      });
    });
    dropdownMenu.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", () => {
        const smallValue = li.querySelector("small")?.textContent.trim();
        const typeCustom = dropdown.querySelector(
          `#type_custom-${this.numbers}`
        );
        const hiddenInput = dropdown.querySelector(
          `#costommerd-${this.numbers}`
        );
        if (hiddenInput && smallValue) {
          hiddenInput.value = smallValue.replace(/\D/g, "");
        }

        this.input_cutommer = li.id;
        typeCustom.value = li.id.replace(/-\d+$/, "");
        data.push({ [`custom-${this.numbers}`]: li.id });

        dropdownMenu.classList.remove("show");
        this.isSelectPrice(this.input_prodcutname, this.input_cutommer);
        this.dispatchEvent(
          new CustomEvent("priceSelected", {
            detail: { numbers: this.numbers, selectId: li.id },
            bubbles: true,
          })
        );
      });
    });
  }

  removeform() {
    if (this.numbers > 0) {
      let div = this.querySelector(".btn-remove");
      const btn = document.createElement("button");
      btn.textContent = "delete";
      btn.classList.add("ml-auto");
      btn.addEventListener("click", () => {
        this.remove();
        createGrandTotal();
        document.dispatchEvent(new Event("recalculate"));
      });
      div.appendChild(btn);
    }
  }
  valueDataProduct() {
    const product_data = this.data ?? [];
    if (product_data) {
      let selectedData = this.querySelector(`.selectedData-${this.numbers}`);
      selectedData.value = `${product_data.productname ?? ""}`;
    }
  }
  renderCreateOrderSell() {
    this.innerHTML = `
            <div class="col-md-12 row mb-3 formGroups" id="formGroup-${
              this.numbers
            }">
              <div class="btn-remove col-md-12 row"></div>
              <div class="col-xl-3 col-lg-7">
                <div class="form-group mb-2">
                  <label class="mt-0 mb-0 font-weight-bold text-dark col-12">รายการสินค้าที่ 
                  <span data-role="index">${Number(this.numbers) + 1}</span>
                  </label>
                    <div class="customInputContainer customInputContainer-${
                      this.numbers
                    }">
                      <div class="customInput-${this.numbers} searchInput-${
      this.numbers
    } customInput searchInput">
                          <input class="selectedData form-control selectedData-${
                            this.numbers
                          }"  type="text" name="product[]" id="name_procts-${
      this.numbers
    }" name="product_name[]" required/>
                      </div>
                      <div class="options-${this.numbers} options">
                          <ul></ul>
                      </div>
                  </div> 
                   
                </div>
              </div>
              <div class="col-xl-3 col-lg-5">
                <div class="form-group mb-2">
                    <label class="m-0 font-weight-bold text-dark col-12" id="x-${
                      this.numbers
                    }">เรทราคา</label>
                      <div class="dropdown dropdown-${this.numbers}">
                        <div class="select select-${this.numbers}">
                          <span>เลือก เรทราคา</span>
                          <i class="fa fa-chevron-left"></i>
                        </div>
                        <input type="text" name="type_custom[]" id="type_custom-${
                          this.numbers
                        }" style="display:none;"/>
                        <ul class="dropdown-menu-${this.numbers} dropdown-menu">
                          <li id="price_customer_frontstore-${
                            this.numbers
                          }" class="row mx-0">
                              ราคาหน้าร้าน
                              <small id="frontstore_price-${
                                this.numbers
                              }" class="ml-auto"></small>
                          </li>
                          <li id="price_custommer_vip-${
                            this.numbers
                          }" class="row mx-0">
                             ราคา วีไอพี่
                           <small id="vip_price-${
                             this.numbers
                           }" class="ml-auto"></small>
                          </li>
                          <li id="price_customer_dealer-${
                            this.numbers
                          }" class="row mx-0">
                              ราคา ตัวแทนจำหน่าย
                              <small id="dealer_price-${
                                this.numbers
                              }" class="ml-auto"></small>
                          </li>
                          <li id="price_customer_deliver-${
                            this.numbers
                          }" class="row mx-0">
                             ราคา จัดส่ง
                            <small id="deliver_price-${
                              this.numbers
                            }" class="ml-auto"></small>
                          </li>
                        </ul>
                        <input type="text" name="costommerds[]" id="costommerd-${
                          this.numbers
                        }" style="display:none;">
                      </div>
                </div>
              </div>
              <div class="col-xl-2 col-lg-4">
                <div class="form-group mb-2">
                  <label class="m-0 font-weight-bold text-dark col-12">จำนวนขายกี่ชิ้น <span class="totalc-${
                    this.numbers
                  }"></span></label>
                  <div class="d-flex">
                    <input type="number" class="form-control mr-2 distotal" name="tatol_product[]" id="tatolproduct-${
                      this.numbers
                    }" placeholder="กรอกจำนวนขาย" required>ชิ้น
                  </div>
                </div>
              </div>
              <div class="col-xl-4 col-lg-8">
                  <div class="form-group mb-2">
                    <label class="m-0 font-weight-bold text-dark col-12">จำนวนชิ้น x ราคาต่อชิ้น = ผลลัพธ์ </label>
                    <div class="form-control">
                      <span id="is_totals-${
                        this.numbers
                      }" class="px-3">&nbsp;</span>
                        <i class="fas fa-times mt-1"></i>
                      <span id="is_count-${
                        this.numbers
                      }" class="px-3" >&nbsp;</span>
                      <i class="fa fa-equals mt-1"></i> 
                      <span id="price_result-${
                        this.numbers
                      }" class="px-3" >&nbsp;</span> บาทถ้วน
                    </div>
                    <input type="hidden" name="resutl_price[]" id="resutl_${
                      this.numbers
                    }"  />
                  </div>
              </div>
            </div>
    `;
  }
}

customElements.define("mian-input-ordersell", formOrDerSell);

class modelSetOrderSell extends HTMLElement {
  connectedCallback() {
    this.selectedLiId = [];
    this.renderCreateOrderSell();
    this.addProductForm();
    this.setIdCostomer();
    this.generateID();
    this.statusPayment();
  }

  generateID() {
    function generateId(length = 8) {
      const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      let result = "";
      for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
      }
      return result;
    }
    const id = generateId(10);
    document.getElementById("ordersell_name").value = id;
  }
  setIdCostomer() {
    this.addEventListener("priceSelected", (e) => {
      const { numbers, selectId } = e.detail;
      this.selectedLiId[numbers] = selectId.replace(/-\d+$/, "");
    });
  }

  addProductForm() {
    const container = this.querySelector("#create-form-order");
    const addForm = this.querySelector("#add-form");

    addForm.addEventListener("click", () => {
      const divIn = this.querySelector("mian-input-ordersell");
      const clone = divIn.cloneNode(true);
      const index =
        container.querySelectorAll("mian-input-ordersell").length + 1;
      clone.setAttribute("numbers", index);
      container.appendChild(clone);
    });
  }

  statusPayment() {
    var $select = $("#payment_options");
    let divPn = document.querySelector("#status_payment");
    divPn.style.display = "none";
    let txt_ui = document.querySelector("#txt-status");
    let ui_count = document.getElementById("count_totalpays");
    let res = document.getElementById("totalPrice");
    let results = document.getElementById("results");
    let count_stuck = document.getElementById("count_stuck");

    $(function () {
      $select.change(function () {
        var result = $select.multipleSelect("getSelects", "text");
        if (result.length > 0) {
          divPn.style.display = "block";
          if (result.includes("ติดค้าง")) {
            ui_count.value = "";
            txt_ui.textContent = "จำนวนเงินที่ยังติดค้าง";
            txt_ui.classList.remove("text-success");
            txt_ui.classList.add("text-danger");
            results.textContent = ` ${res.innerHTML} บาท`;
            results.classList.add("text-danger");
            count_stuck.value = Number(res.innerHTML);
          } else {
            txt_ui.textContent = "จ่ายครบถ้วน";
            txt_ui.classList.remove("text-danger");
            txt_ui.classList.add("text-success");
            results.textContent = "";
            ui_count.value = res.innerHTML;
            count_stuck.value = 0;
          }
        } else {
          divPn.style.display = "none";
        }
      });
    });
  }

  renderCreateOrderSell() {
    this.innerHTML = `
      <div class="modal fade" id="modalFormOrderSell" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
              <div class="modal-content" id="">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มรายการขาย <span id="productname"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="myForm" method="POST" action="backend/order_sell.php" enctype="multipart/form-data">
                  <input type="hidden" name="status_form" value="create" />
                    <div class="modal-body">
                      <mian-input-ordersell numbers="0"></mian-input-ordersell>
                      <div class="" id="create-form-order">
                      </div>
                      <div class="row col-12 mt-2 mb-4">
                        <button type="button" class="btn btn-sm btn-success ml-auto mr-4" id="add-form">เพิ่ม สินค้า</button>
                      </div>
                      <div class="col-12 row mb-3 border mt-4 py-3">
                        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12">
                            <div class="row">
                              <div class="col-xl-5 col-lg-8 col-sm-12">
                                <div class="form-group mb-2">
                                  <label class="mt-0 mb-0 font-weight-bold text-dark">รายการขาย <span class="text-danger">*</span> </label>
                                  <input type="text" class="form-control" name="ordersell_name" id="ordersell_name" placeholder="รายการขาย" required>
                                </div> 
                              </div>
                              <div class="col-xl-7 col-lg-4 col-sm-12">
                                  <div class="form-group mb-2">
                                    <label class="m-0 font-weight-bold text-dark">ราคาที่ต้องจ่าย <span class="text-danger">*</span></label>
                                    <div class="row">
                                      <div class="form-control col-5 ml-2">
                                        <span id="totalPrice">0</span>
                                        <input type="hidden" name="is_totalprice" id="is_totalprice"/>
                                      </div>
                                      <div class="col-6 row">
                                        <div class="col-6 align-self-center">
                                          <span class="font-weight-bold" id="totalOrder">0 รายการ</span>
                                        </div>
                                        <div class="col-6 align-self-center row ml-auto">
                                            <span class="font-weight-bold" id="totalProducts">0 ชิ้น</span>
                                        </div>
                                      </div>
                                      
                                    </div>
                                  </div>
                              </div>
                            </div>
                            <main-get-select></main-get-select>
                            <div class="row">
                              <div class="col-xl-8 col-md-12 pl-3">
                                <div class="form-group mb-2 shipping-state">
                                  <label class="mt-0 mb-0 font-weight-bold text-dark">หมายเหตุการจัดส่ง</label>
                                  <div class="row">
                                      <input type="text" class="ml-3 mr-1 py-2 form-control col-md-6 col-sm-12" name="sender" id="sender" placeholder="ผู้ส่ง">
                                      <input type="text" class=" form-control py-2 col-md-5 col-sm-12" name="tell_sender" id="tell_sender" placeholder="เบอร์โทรผู้ส่ง">
                                  </div>
                                </div> 
                              </div>
                              <div class="col-xl-4 pl-0 col-md-12">
                                <label class="mt-0 mb-0 col-12 font-weight-bold text-dark">ตัวเลือกการจ่าย <span class="text-danger">*</span></label>
                                <select class="form-control multiple-select" name="payment_option[]" id="payment_options" placeholder="ตัวเลือกการจ่าย" multiple="multiple" required>
                                    <option value="โอน">โอน</option>
                                    <option value="จ่ายสด">จ่ายสด</option>
                                    <option value="ติดค้าง">ติดค้าง</option>
                                </select>
                              </div>
                              
                              <div class="col-12">                         
                                  <label for="exampleFormControlTextarea1">เหตุผล(ถ้ามี)</label>
                                  <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="2"></textarea>
                              </div>
                              
                            </div>
                          
                        </div>
                        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
                          <mian-add-image id="slip_orderseller" count="sell_slip" wrapper="ux-wrap" filenames="uimgname" cancles="ux-cancle"
                            names="รูปโปรไฟล์" custom="btn_custom" setdefault="setDefaultImgSell"></mian-add-image>
                          <div class="col-12" id="status_payment">
                              <label for="" class="small">จำนวนเงินที่ลูกค้าจ่าย <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" name="count_totalpays" id="count_totalpays" placeholder="จำนวนเงินที่ลูกค้าจ่าย" required>
                              <input type="hidden" class="form-control" name="count_stuck" id="count_stuck" value="0" placeholder="จำนวนเงินที่ลูกค้าจ่าย">
                              <div class="align-self-center row mt-2 ml-2" id="is_stock">
                                <b id="txt-status"></b> <span class="ml-2 font-weight-bold" id="results"></span>
                              </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary ml-auto mr-4">บันทึกข้อมูล</button>
                    </div>
                </form>
              </div>
          </div>
      </div>
    `;
  }
}

customElements.define("mian-form-ordersell", modelSetOrderSell);

// <div class="col-xl-5 col-md-7">
//      <div class="form-group mb-2">
//        <label class="mt-0 mb-0 font-weight-bold text-dark">ชื่อลูกค้า <span class="text-danger">*</span></label>
//        <input type="text" class="form-control" name="custome_name" id="custome_name" placeholder="ชื่อ" required>
//      </div>
//    </div>
//    <div class="col-xl-4 col-md-5">
//      <div class="form-group mb-2">
//        <label class="mt-0 mb-0 font-weight-bold text-dark">เบอร์โทร <span class="text-danger">*</span></label>
//        <input type="text" class="form-control" name="tell_custome" id="tell_custome" placeholder="เบอร์โทร" required>
//      </div>
//    </div>
//  <div class="col-xl-3 col-md-5">
//    <div class="form-group mb-2">
//      <label class="mt-0 mb-0 font-weight-bold text-dark">วันที่และเวลา <span class="text-danger">*</span></label>
//      <input type="datetime-local" class="form-control" name="date_time_sell" id="date_time_sell" placeholder="วันที่และเวลา" required>
//    </div>
//  </div>
{
  /* <div class="col-12">
                                    <label class="mt-0 mb-0 font-weight-bold text-dark">ที่อยู่ในการจัดส่ง</label>
                                    <input type="text" class="form-control" name="location_send" id="location_send" placeholder="ที่อยู่ในการจัดส่ง">
                              </div> */
}

class SelectCustome extends HTMLElement {
  constructor() {
    super();
  }
  customdata = [];
  async connectedCallback() {
    await this.loadData();
    this.render();
    this.scriptCodeCustome();
  }

  async loadData() {
    try {
      const response = await fetch(
        "http://localhost/stockproduct/system/backend/api/customer_api.php",
        {
          method: "GET",
          credentials: "include",
        }
      );
      const responsedata = await response.json();
      this.customdata.push(responsedata.data);
      return responsedata;
    } catch (e) {
      console.error(`Is Error ${e}`);
    }
  }
  updateData(data_custome, index, group) {
    console.log({ data_custome });
    this.scriptTell(data_custome);
    this.scriptLocation(data_custome);
    let selectedData = group.querySelector(`.IsselectedData-${index}`);
    let customInputContainer = document.querySelector(
      `.IscustomInputContainer-${index}`
    );
    const ul = group.querySelector("ul");
    selectedData.value = data_custome ?? "";
    for (const li of group.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find(
      (li) => li.innerText === data_custome
    );
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }
  scriptCodeCustome() {
    const index = 1;
    let isForm = document.querySelector(".is-form");
    let getSelect = isForm.querySelector(".getSelect");
    let customInputContainer = getSelect.querySelector(".customInputContainer");
    let customInput = getSelect.querySelector(`.customInput`);

    let selectedData = getSelect.querySelector(".selectedData");
    let serchInput = getSelect.querySelector(".searchInput input");
    let ul = getSelect.querySelector(`.options ul`);

    customInput.classList.add(`IscustomInput-${index}`);
    getSelect.classList.add(`IscustomInputContainer-${index}`);
    selectedData.classList.add(`IsselectedData-${index}`);
    serchInput.classList.add(`IsserchInput-${index}`);
    ul.classList.add(`Isoptions-${index}`);

    window.addEventListener("click", (e) => {
      const searchInputEl = getSelect.querySelector(`.IssearchInput-${index}`);
      if (searchInputEl && searchInputEl.contains(e.target)) {
        searchInputEl.classList.add("focus");
      } else if (searchInputEl) {
        searchInputEl.classList.remove("focus");
      }
      if (customInputContainer && !customInputContainer.contains(e.target)) {
        customInputContainer.classList.remove("show");
      }
    });
    customInput.addEventListener("click", () => {
      customInputContainer.classList.add("show");
    });
    for (let i = 0; i < this.customdata[0].length; i++) {
      let custom = this.customdata[0][i];
      let li = document.createElement("li");
      li.classList.add("block");
      const row = document.createElement("div");
      row.classList.add("row");
      let span = document.createElement("span");
      span.textContent = custom.custome_name;
      row.appendChild(span);
      li.appendChild(row);
      ul.appendChild(li);
    }
    ul.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", () => {
        let spanTxt = li.querySelector("span").innerText;
        this.scriptTell(spanTxt);
        this.scriptLocation(spanTxt);
        selectedData.value = spanTxt;
        for (const li of document.querySelectorAll("li.selected")) {
          li.classList.remove("selected");
        }
        li.classList.add("selected");
        customInputContainer.classList.toggle("show");
      });
    });
    serchInput.addEventListener("keyup", () => {
      let searchedVal = serchInput.value.toLowerCase();
      let searched_product = this.customdata[0].filter((data) =>
        data.custome_name.toLowerCase().includes(searchedVal)
      );
      console.log({ searched_product });
      ul.innerHTML = "";
      if (searched_product.length === 0) {
        ul.innerHTML = "";
        return;
      }
      searched_product.forEach((data) => {
        const li = document.createElement("li");
        li.textContent = data.custome_name;
        li.addEventListener("click", (e) => {
          this.updateData(e.target.textContent, index, getSelect);
        });
        ul.appendChild(li);
      });
    });
  }

  updateDataTell(data_tell, index, group) {
    console.log({ data_tell });
    let selectedData = group.querySelector(`.IsselectedTellData-${index}`);
    let customInputContainer = document.querySelector(
      `.IsTellInputContainer-${index}`
    );
    const ul = group.querySelector("ul");
    selectedData.value = data_tell ?? "";
    for (const li of group.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find((li) => li.innerText === data_tell);
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }

  scriptTell(customename) {
    if (customename) {
      const index = 2;
      const customes = this.customdata[0].filter((data) =>
        data.custome_name.toLowerCase().includes(customename)
      );
      const isTell = document.querySelector(".is-tell");
      let getSelectTell = isTell.querySelector(".getSelectTell");
      let customInputContainer = getSelectTell.querySelector(
        ".customInputContainer"
      );
      let customInput = getSelectTell.querySelector(`.customInput`);

      let selectedData = getSelectTell.querySelector(".selectedData");
      let serchInput = getSelectTell.querySelector(".searchInput input");
      let ul = getSelectTell.querySelector(`.options ul`);
      customInput.classList.add(`IsTellInput-${index}`);
      getSelectTell.classList.add(`IsTellInputContainer-${index}`);
      selectedData.classList.add(`IsselectedTellData-${index}`);
      serchInput.classList.add(`IsTellserchInput-${index}`);
      ul.classList.add(`IsTelloptions-${index}`);

      selectedData.value = "";

      window.addEventListener("click", (e) => {
        const searchInputEl = getSelectTell.querySelector(
          `.IsTellserchInput-${index}`
        );
        if (searchInputEl && searchInputEl.contains(e.target)) {
          searchInputEl.classList.add("focus");
        } else if (searchInputEl) {
          searchInputEl.classList.remove("focus");
        }
        if (customInputContainer && !customInputContainer.contains(e.target)) {
          customInputContainer.classList.remove("show");
        }
      });
      customInput.addEventListener("click", () => {
        customInputContainer.classList.add("show");
      });
      ul.innerHTML = "";
      if (customes.length > 0 && customes[0].customtell) {
        for (let i = 0; i < customes[0].customtell.length; i++) {
          let custom = customes[0].customtell;
          let li = document.createElement("li");
          li.classList.add("block");
          const row = document.createElement("div");
          row.classList.add("row");
          let span = document.createElement("span");
          span.textContent = custom[i];
          row.appendChild(span);
          li.appendChild(row);
          ul.appendChild(li);
        }
      }
      ul.querySelectorAll("li").forEach((li) => {
        li.addEventListener("click", () => {
          let spanTxt = li.querySelector("span").innerText;
          selectedData.value = spanTxt;
          for (const li of document.querySelectorAll("li.selected")) {
            li.classList.remove("selected");
          }
          li.classList.add("selected");
          customInputContainer.classList.toggle("show");
        });
      });

      serchInput.addEventListener("keyup", () => {
        let searchedVal = serchInput.value.toLowerCase();
        if (customes.length > 0 && Array.isArray(customes[0].customtell)) {
          let searched_product = customes[0].customtell.filter((data) =>
            data.toLowerCase().includes(searchedVal)
          );
          ul.innerHTML = "";
          if (searched_product.length === 0) {
            ul.innerHTML = "";
            return;
          }
          searched_product.forEach((data) => {
            const li = document.createElement("li");
            console.log({ data });
            li.textContent = data;
            li.addEventListener("click", (e) => {
              this.updateDataTell(e.target.textContent, index, getSelectTell);
            });
            ul.appendChild(li);
          });
        }
      });
    }
  }

  updateDataLocation(data_location, index, group) {
    console.log({ data_location });
    let selectedLocationData = group.querySelector(
      `.IsselectedLocationData-${index}`
    );
    let customInputContainer = document.querySelector(
      `.IsLocationInputContainer-${index}`
    );
    const ul = group.querySelector("ul");
    selectedLocationData.value = data_location ?? "";
    for (const li of group.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find(
      (li) => li.innerText === data_location
    );
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }

  scriptLocation(customername) {
    if (customername) {
      const index = 3;
      const customes = this.customdata[0].filter((data) =>
        data.custome_name.toLowerCase().includes(customername)
      );
      const isLocation = document.querySelector(".is-loaction");
      let getSelectLocation = isLocation.querySelector(".getSelectLocation");
      let customInputContainer = getSelectLocation.querySelector(
        ".customInputContainer"
      );
      let customInput = getSelectLocation.querySelector(`.customInput`);

      let selectedData = getSelectLocation.querySelector(".selectedData");
      let serchInput = getSelectLocation.querySelector(".searchInput input");
      let ul = getSelectLocation.querySelector(`.options ul`);
      customInput.classList.add(`IsLocationInput-${index}`);
      getSelectLocation.classList.add(`IsLocationInputContainer-${index}`);
      selectedData.classList.add(`IsselectedLocationData-${index}`);
      serchInput.classList.add(`IsLocationserchInput-${index}`);
      ul.classList.add(`IsLocationoptions-${index}`);

      selectedData.value = "";

      window.addEventListener("click", (e) => {
        const searchInputEl = getSelectLocation.querySelector(
          `.IsLocationserchInput-${index}`
        );
        if (searchInputEl && searchInputEl.contains(e.target)) {
          searchInputEl.classList.add("focus");
        } else if (searchInputEl) {
          searchInputEl.classList.remove("focus");
        }
        if (customInputContainer && !customInputContainer.contains(e.target)) {
          customInputContainer.classList.remove("show");
        }
      });
      customInput.addEventListener("click", () => {
        customInputContainer.classList.add("show");
      });
      ul.innerHTML = "";
      if (customes.length > 0 && customes[0].customlocation) {
        console.log("[", customes);
        for (let i = 0; i < customes[0].customlocation.length; i++) {
          let custom = customes[0].customlocation;
          console.log("LO=", i);
          console.log("LO=", custom);
          let li = document.createElement("li");
          li.classList.add("block");
          const row = document.createElement("div");
          row.classList.add("row");
          let span = document.createElement("span");
          span.textContent = custom[i];
          row.appendChild(span);
          li.appendChild(row);
          ul.appendChild(li);
        }
      }
      ul.querySelectorAll("li").forEach((li) => {
        li.addEventListener("click", () => {
          let spanTxt = li.querySelector("span").innerText;
          selectedData.value = spanTxt;
          for (const li of document.querySelectorAll("li.selected")) {
            li.classList.remove("selected");
          }
          li.classList.add("selected");
          customInputContainer.classList.toggle("show");
        });
      });

      serchInput.addEventListener("keyup", () => {
        let searchedVal = serchInput.value.toLowerCase();

        if (customes.length > 0 && Array.isArray(customes[0].customlocation)) {
          let searched_product = customes[0].customlocation.filter((data) =>
            data.toLowerCase().includes(searchedVal)
          );
          ul.innerHTML = "";
          if (searched_product.length === 0) {
            ul.innerHTML = "";
            return;
          }
          searched_product.forEach((data) => {
            const li = document.createElement("li");
            console.log({ data });
            li.textContent = data;
            li.addEventListener("click", (e) => {
              this.updateDataLocation(
                e.target.textContent,
                index,
                getSelectLocation
              );
            });
            ul.appendChild(li);
          });
        }
      });
    }
  }
  render() {
    this.innerHTML = `
    <div class="row col-12 p-0">
      <div class="col-xl-5 col-md-7 is-form">
        <div class="getSelect form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark">ชื่อลูกค้า <span class="text-danger">*</span></label>
          <div class="customInputContainer">
              <div class="customInput searchInput">
                  <input class="selectedData form-control cusotmer_name"  type="text" name="custome_name" required/>
              </div>
              <div class="options">
                  <ul></ul>
              </div>
          </div>
        </div> 
      </div>

      <div class="col-xl-4 col-md-5 is-tell">
        <div class="getSelectTell form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark">เบอร์โทร <span class="text-danger">*</span></label>
          <div class="customInputContainer">
              <div class="customInput searchInput">
                  <input class="selectedData form-control cusotmer_tell"  type="text" name="tell_custome" required/>
              </div>
              <div class="options">
                  <ul></ul>
              </div>
          </div>
        </div> 
      </div>

      <div class="col-xl-3 col-md-5">
        <div class="form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark">วันที่และเวลา <span class="text-danger">*</span></label>
          <input type="datetime-local" class="form-control" name="date_time_sell" id="date_time_sell" placeholder="วันที่และเวลา" required>
        </div> 
      </div>
      <div class="col-12 is-loaction">
        <div class="getSelectLocation form-group mb-2">
            <label class="mt-0 mb-0 font-weight-bold text-dark">ที่อยู่ในการจัดส่ง</label>
            <div class="customInputContainer">
              <div class="customInput searchInput">
                  <input class="selectedData form-control location_send"  type="text" name="location_send" placeholder="ที่อยู่ในการจัดส่ง" required/>
              </div>
              <div class="options">
                  <ul></ul>
              </div>
          </div>
        </div>
      </div>
    </div>
    `;
  }
}

customElements.define("main-get-select", SelectCustome);

$(document).on("click", "#confirmTrashOrderSell", function (e) {
  let idorder_sell = $(this).data("id");
  let order_sellname = $(this).data("ordersell");
  console.log({ idorder_sell, order_sellname });
  Swal.fire({
    title: "คุณแน่ใจไหม ?",
    text: `รายการ ${order_sellname} นี้ พร้อมสินค้า จะถูกลบทั้งหมด จะไม่สามารถย้อนกลับได้`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "ยกเลิก",
    confirmButtonText: "ยืนยัน",
  }).then(async (result) => {
    if (result.isConfirmed) {
      try {
        const responseapi = await fetch(
          `http://localhost/stockproduct/system/backend/api/stockordersell.php?ordersell_id=${idorder_sell}`,
          {
            method: "DELETE",
            credentials: "include",
          }
        );
        const responsedata = await responseapi.json();
        if (responsedata.status === 201) {
          console.log(responsedata);
          Swal.fire({
            title: "เรียบร้อย",
            text: "ลบ order นี้เรียบร้อยแล้ว",
            icon: "success",
            showConfirmButton: false,
          }).then(() => {
            window.location.reload();
          });
        }
      } catch (e) {
        throw new Error(`Is Error Catch ${e}`);
      }
    }
  });
});
