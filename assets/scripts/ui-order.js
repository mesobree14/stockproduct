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
    this.isSetImagePriviews();
  }
  isSetImagePriviews() {
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

const uiForm = `    
      <div class="col-md-12">
        <div class=row col-12">
        <button type="button" class="remove-btn ml-auto my-2">❌ ลบ</button>
        </div>
        <div class="form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark labelCount"></label>
          <div class="customInputContainer">
              <div class="customInput searchInput">
                  <input class="selectedData form-control c_product_name"  type="text" name="product_name[]" required/>
              </div>
              <div class="options">
                  <ul></ul>
              </div>
          </div>
        </div>  
      </div>
      <div class="col-md-12 row">
        <div class="col-md-5">
          <div class="form-group mb-2">
            <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
            <input type="text" class="c_count_product form-control" name="count_product[]" id="" placeholder="ชื่อสินค้า" required>
          </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
              <label class="mt-0 mb-0 font-weight-bold text-dark">ราคาต้นทุน/ชิ้น</label>
              <input type="text" class="c_price_product form-control" name="price_product[]" id="" placeholder="ชื่อสินค้า" required>
            </div>
        </div>
        <div class="col-md-3 align-self-center">
            <div class="form-group mb-2">
              <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
              <input type="text" class="c_expenses form-control" name="expenses[]" placeholder="ค่าใช้จ่าย" required>
            </div>
        </div>
      </div>
    `;

const createGrandTotal = (capital = []) => {
  let valueInput = document.getElementById("totalcost_order");
  const results = document.querySelectorAll("input[id^='expenses-']");
  let totalPrice = 0;
  results.forEach((span) => {
    const value = Number(span.value.trim());
    if (!isNaN(value)) {
      totalPrice += value;
    }
  });
  if (totalPrice > Number(capital[0].funds_that_can_be_used)) {
    valueInput.style.color = "red";
    valueInput.style.border = "2px solid red";
  } else {
    valueInput.style.color = "green";
    valueInput.style.border = "2px solid green";
  }
  document.getElementById("totalcost_order").value = totalPrice;
};

class modelCreateOrder extends HTMLElement {
  constructor() {
    super();
  }

  stockproducts = [];
  financedata = [];
  async connectedCallback() {
    await this.loadProduct();

    this.renderCreateOrder();
    this.scripts();
    this.generateID();
    await this.loadBeUseCapital();
  }

  async loadBeUseCapital() {
    try {
      const api_finance = await fetch(
        "http://localhost/stockproduct/system/backend/api/api_capital_withdraw.php",
        {
          method: "GET",
          credentials: "include",
        }
      );
      const response = await api_finance.json();
      this.financedata.push(response.data);
      let span = document.getElementById("funds_that_can_be_used");

      span.textContent = `ทุนที่มี ${response.data.funds_that_can_be_used}`;

      if (
        Number(response.data.funds_that_can_be_used.replace(/,/g, "").trim()) >
        0
      ) {
        span.classList.add("text-success");
        span.classList.remove("text-danger");
      } else {
        span.classList.add("text-danger");
        span.classList.remove("text-success");
      }

      return response.data;
    } catch (e) {
      throw new Error(`Is Error : ${e}`);
    }
  }
  async loadProduct() {
    try {
      const api_data = await fetch(
        "http://localhost/stockproduct/system/backend/api/stock.php",
        {
          method: "GET",
          credentials: "include",
        }
      );
      const response = await api_data.json();
      this.stockproducts.push(...response.data);
      return response.data;
    } catch (e) {
      throw new Error(`Is Error : ${e}`);
    }
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
    document.getElementById("orderbuy_name").value = id;
  }

  updateData(data_product, index, group) {
    let selectedData = group.querySelector(`.IsselectedData-${index}`);
    let customInputContainer = group.querySelector(
      `.IscustomInputContainer-${index}`
    );
    const ul = group.querySelector("ul");
    selectedData.value = data_product ?? "";
    for (const li of group.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find(
      (li) => li.innerText === data_product
    );
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }

  scripts() {
    const container = document.getElementById("formcreateorder");

    const CountForm = () => {
      const group = container.querySelectorAll(".formGroup");
      group.forEach((group, index) => {
        let label = group.querySelector("label");
        label.textContent = `ชื่อสินค้าตัวที่ ${index + 1}`;

        let customInput = group.querySelector(`.customInput`);
        let customInputContainer = group.querySelector(".customInputContainer");
        let selectedData = group.querySelector(".selectedData");
        let serchInput = group.querySelector(".searchInput input");
        let ul = group.querySelector(`.options ul`);

        customInput.classList.add(`IscustomInput-${index}`);
        customInputContainer.classList.add(`IscustomInputContainer-${index}`);
        selectedData.classList.add(`IsselectedData-${index}`);
        serchInput.classList.add(`IsserchInput-${index}`);
        ul.classList.add(`Isoptions-${index}`);

        window.addEventListener("click", (e) => {
          const searchInputEl = group.querySelector(`.IssearchInput-${index}`);
          if (searchInputEl && searchInputEl.contains(e.target)) {
            searchInputEl.classList.add("focus");
          } else if (searchInputEl) {
            searchInputEl.classList.remove("focus");
          }
          if (
            customInputContainer &&
            !customInputContainer.contains(e.target)
          ) {
            customInputContainer.classList.remove("show");
          }
        });
        customInput.addEventListener("click", () => {
          customInputContainer.classList.add("show");
        });
        for (let i = 0; i < this.stockproducts.length; i++) {
          let product = this.stockproducts[i];
          let li = document.createElement("li");
          li.classList.add("block");
          const row = document.createElement("div");
          row.classList.add("row");
          let span = document.createElement("span");
          let small = document.createElement("small");
          span.textContent = product.product_name;
          small.textContent = `เหลืออีก ${product.remaining_product} ชิ้น`;
          small.classList.add("ml-auto");
          row.appendChild(span);
          row.appendChild(small);
          li.appendChild(row);
          ul.appendChild(li);
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
          let searched_product = this.stockproducts.filter((data) =>
            data.product_name.toLowerCase().includes(searchedVal)
          );
          console.log({ searched_product });
          ul.innerHTML = "";
          if (searched_product.length === 0) {
            ul.innerHTML = "";
            return;
          }
          searched_product.forEach((data) => {
            const li = document.createElement("li");
            li.textContent = data.product_name;
            li.addEventListener("click", (e) => {
              this.updateData(e.target.textContent, index, group);
            });
            ul.appendChild(li);
          });
        });

        let product_name = group.querySelector(".c_product_name");
        let count_product = group.querySelector(".c_count_product");
        let price_product = group.querySelector(".c_price_product");
        let expenses = group.querySelector(".c_expenses");
        product_name.id = `product_name-${index}`;
        count_product.id = `count_product-${index}`;
        price_product.id = `price_product-${index}`;
        expenses.id = `expenses-${index}`;
        count_product.addEventListener("input", (e) => {
          let value = e.target.value;
          console.log("SS=", value);
          price_product.value = Number((expenses.value / value).toFixed(2));
          createGrandTotal(this.financedata);
        });

        price_product.addEventListener("input", (e) => {
          let value = e.target.value;
          expenses.value = Number((count_product.value * value).toFixed(2));
          createGrandTotal(this.financedata);
        });

        expenses.addEventListener("input", (e) => {
          let value = e.target.value;
          price_product.value = Number(
            (value / count_product.value).toFixed(2)
          );
          createGrandTotal(this.financedata);
        });
      });
    };
    document.getElementById("add-form").addEventListener("click", function () {
      const div = document.createElement("div");
      div.className = "formGroup col-md-12 border mb-3";
      div.innerHTML = uiForm;
      container.appendChild(div);
      div.querySelector(".remove-btn").addEventListener("click", function () {
        div.remove();
        CountForm();
        createGrandTotal();
        document.dispatchEvent(new Event("recalculate"));
      });
      CountForm();
    });
    CountForm();
  }
  renderCreateOrder() {
    this.innerHTML = `
    <div class="modal fade bd-example-modal-xl" id="modalFormCreateOrder" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">สินค้าที่สั่งซื้อ</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="myForm" method="post" action="backend/create_order.php" enctype="multipart/form-data">
              <input type="hidden" name="status_form" value="create" />
              <div class="modal-body">
                <div class="mt-2 row border">
                  <div class="col-md-8">
                      <div class="col-md-12">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">รายการคำสั่งซื้อ</label>
                          <input type="text" class="form-control" name="order_name" id="orderbuy_name" placeholder="รายการคำสั่งซื้อ" required>
                        </div> 
                      </div>

                      <div class="col-md-12 row">
                        <div class="col-md-7">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่ายทั้งหมด</label>
                            <input type="text" class="form-control" name="totalcost_order" id="totalcost_order" placeholder="ค่าใช้จ่าย" required>
                          </div> 
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label class="mt-0 mb-0 font-weight-bold text-dark align-self-center mt-4">บาท <span id="funds_that_can_be_used"></span></label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">วันที่และเวลา</label>
                          <input type="datetime-local" class="form-control" name="date_time_order" id="" placeholder="วันที่และเวลา" required>
                        </div> 
                      </div>
                  </div>
                  <div class="col-md-4">
                    <mian-add-image id="orphanImage" count="slipt_order" wrapper="x-wrapX" filenames="ximgnameX" cancles="x-cancleX"
                      names="รูปโปรไฟล์" custom="setbtnCustomX" setdefault="setDefaultImgOrphan"></mian-add-image>
                  </div>
                </div>
                
                <div id="formcreateorder">
                <div class="col-md-12 border mb-3 formGroup">
                    <div class="col-md-12">
                      <div class="form-group mb-2">
                        <label class="mt-0 mb-0 font-weight-bold text-dark">ชื่อสินค้าตัวที่1</label>
                        <div class="customInputContainer">
                            <div class="customInput searchInput">
                                <input class="selectedData form-control c_product_name"  type="text" name="product_name[]" required/>
                            </div>
                            <div class="options">
                                <ul></ul>
                            </div>
                        </div>
                      </div>  
                    </div>
                    <div class="col-md-12 row">
                      <div class="col-md-5">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
                          <input type="text" class="c_count_product form-control" name="count_product[]"placeholder="จำนวน" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ราคาต้นทุน/ชิ้น</label>
                            <input type="text" class="c_price_product form-control" name="price_product[]" placeholder="ราคาต้นทุน" required>
                          </div>
                      </div>
                      <div class="col-md-3 align-self-center">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
                            <input type="text" class="c_expenses form-control" name="expenses[]" placeholder="ค่าใช้จ่าย" required>
                          </div>
                      </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12 row mt-4">
                  <button type="button" class="btn btn-sm btn-success ml-auto mr-4" id="add-form">เพิ่ม สินค้า</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-primary ml-auto mr-4">บันทึกข้อมูล</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    `;
  }
}
customElements.define("main-create-order", modelCreateOrder);

const uiFormUpdate = `    
      <div class="col-md-12">
        <div class=row col-12">
        <button type="button" class="remove-btn ml-auto my-2">❌ ลบ</button>
        </div>
        <div class="form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark labelCount"></label>
          <div class="customInputContainer">
              <div class="customInput searchInput">
                  <input class="selectedData form-control u_product_name"  type="text" name="product_name[]" required/>
              </div>
              <div class="options">
                  <ul></ul>
              </div>
          </div>
        </div>  
      </div>
      <div class="col-md-12 row">
        <div class="col-md-5">
          <div class="form-group mb-2">
            <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
            <input type="text" class="u_count_product form-control" name="count_product[]" id="" placeholder="ชื่อสินค้า" required>
          </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
              <label class="mt-0 mb-0 font-weight-bold text-dark">ราคาต้นทุน/ชิ้น</label>
              <input type="text" class="u_price_product form-control" name="price_product[]" id="" placeholder="ชื่อสินค้า" required>
            </div>
        </div>
        <div class="col-md-3 align-self-center">
            <div class="form-group mb-2">
              <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
              <input type="text" class="u_expenses form-control" name="expenses[]" placeholder="ค่าใช้จ่าย" required>
            </div>
        </div>
      </div>
    `;

const updateGrandTotal = (capital = []) => {
  let valueInput = document.getElementById("add-price");
  let def_value = document.getElementById("defult-price");

  console.log(def_value.textContent.match(/[0-9.]+/)[0]);
  const results = document.querySelectorAll("input[id^='e-expenses-']");
  let totalPrice = 0;
  results.forEach((span) => {
    const value = Number(span.value.trim());
    if (!isNaN(value)) {
      totalPrice += value;
    }
  });
  let del = totalPrice - Number(def_value.textContent.match(/[0-9.]+/)[0]);

  if (del > Number(capital[0].funds_that_can_be_used)) {
    valueInput.style.color = "red";
    valueInput.textContent = `เพิ่มมา ${del} บาท เกินงบ`;
  } else {
    valueInput.style.color = "green";
    valueInput.textContent = `เพิ่มมา ${del} บาท`;
  }

  document.getElementById("totalcost_orders").value = totalPrice;
};
class modelUpdateOrder extends HTMLElement {
  stockproductAll = [];
  stockproducts_id = [];
  financedata = [];
  connectedCallback() {
    this.addEventListener("setId", (e) => {
      this.productId = e.detail;
      this.loadOrder(this.productId);
      this.scripts();
    });
    this.loadProductAll();

    this.renderUpdateOrder();
    this.countterForm();
    this.loadBeUseCapital();
  }

  async loadBeUseCapital() {
    try {
      const api_finance = await fetch(
        "http://localhost/stockproduct/system/backend/api/api_capital_withdraw.php",
        {
          method: "GET",
          credentials: "include",
        }
      );
      const response = await api_finance.json();
      this.financedata.push(response.data);
      let span = document.getElementById("u_funds_that_can_be_used");
      span.textContent = `ทุนที่มี ${response.data.funds_that_can_be_used}`;

      if (
        Number(response.data.funds_that_can_be_used.replace(/,/g, "").trim()) >
        0
      ) {
        span.classList.add("text-success");
        span.classList.remove("text-danger");
      } else {
        span.classList.add("text-danger");
        span.classList.remove("text-success");
      }

      return response.data;
    } catch (e) {
      throw new Error(`Is Error : ${e}`);
    }
  }

  async loadProductAll() {
    try {
      const api_data = await fetch(
        "http://localhost/stockproduct/system/backend/api/stock.php",
        {
          method: "GET",
          credentials: "include",
        }
      );

      const responsedata = await api_data.json();
      this.stockproductAll.push(...responsedata.data);
      return responsedata.data;
    } catch (e) {
      throw new Error(`Is Error Get data ${e}`);
    }
  }

  updateData(data_product, index, group) {
    let selectedData = group.querySelector(`.IsselectedData-${index}`);
    let customInputContainer = group.querySelector(
      `.IscustomInputContainer-${index}`
    );
    const ul = group.querySelector("ul");
    selectedData.value = data_product ?? "";
    for (const li of group.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    const clickedLi = [...ul.children].find(
      (li) => li.innerText === data_product
    );
    if (clickedLi) clickedLi.classList.add("selected");
    customInputContainer.classList.toggle("show");
  }

  countterForm() {
    const container = document.getElementById("formupdateorder");
    const group = container.querySelectorAll(".formGroup");
    group.forEach((group, index) => {
      let label = group.querySelector("label");
      label.textContent = `ชื่อสินค้าตัวที่ ${index + 1}`;

      let customInput = group.querySelector(`.customInput`);
      let customInputContainer = group.querySelector(".customInputContainer");
      let selectedData = group.querySelector(".selectedData");
      let serchInput = group.querySelector(".searchInput input");
      let ul = group.querySelector(`.options ul`);

      customInput.classList.add(`IscustomInput-${index}`);
      customInputContainer.classList.add(`IscustomInputContainer-${index}`);
      selectedData.classList.add(`IsselectedData-${index}`);
      serchInput.classList.add(`IsserchInput-${index}`);
      ul.classList.add(`Isoptions-${index}`);

      window.addEventListener("click", (e) => {
        const searchInputEl = group.querySelector(`.IssearchInput-${index}`);
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
      for (let i = 0; i < this.stockproductAll.length; i++) {
        let product = this.stockproductAll[i];
        let li = document.createElement("li");
        li.classList.add("block");
        const row = document.createElement("div");
        row.classList.add("row");
        let span = document.createElement("span");
        let small = document.createElement("small");
        span.textContent = product.product_name;
        small.textContent = `เหลืออีก ${product.remaining_product} ชิ้น`;
        small.classList.add("ml-auto");
        row.appendChild(span);
        row.appendChild(small);
        li.appendChild(row);
        ul.appendChild(li);
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
        let searched_product = this.stockproductAll.filter((data) =>
          data.product_name.toLowerCase().includes(searchedVal)
        );
        ul.innerHTML = "";
        if (searched_product.length === 0) {
          ul.innerHTML = "";
          return;
        }
        searched_product.forEach((data) => {
          const li = document.createElement("li");
          li.textContent = data.product_name;
          li.addEventListener("click", (e) => {
            this.updateData(e.target.textContent, index, group);
          });
          ul.appendChild(li);
        });
      });
      let product_name = group.querySelector(".u_product_name");
      let count_product = group.querySelector(".u_count_product");
      let price_product = group.querySelector(".u_price_product");
      let expenses = group.querySelector(".u_expenses");
      product_name.id = `e-product_name-${index}`;
      count_product.id = `e-count_product-${index}`;
      price_product.id = `e-price_product-${index}`;
      expenses.id = `e-expenses-${index}`;
      count_product.addEventListener("input", (e) => {
        let value = e.target.value;
        price_product.value = Number((expenses.value / value).toFixed(2));
        updateGrandTotal(this.financedata);
      });

      price_product.addEventListener("input", (e) => {
        let value = e.target.value;
        expenses.value = Number((count_product.value * value).toFixed(2));
        updateGrandTotal(this.financedata);
      });

      expenses.addEventListener("input", (e) => {
        let value = e.target.value;
        price_product.value = Number((value / count_product.value).toFixed(2));
        updateGrandTotal(this.financedata);
      });
    });
  }

  async loadOrder(productId) {
    try {
      const response = await fetch(
        `http://localhost/stockproduct/system/backend/api/order.php?order_id=${productId}`,
        {
          method: "GET",
          credentials: "include",
        }
      );

      const data = await response.json();
      this.stockproducts_id.push(...data.data);
      const container = document.getElementById("formupdateorder");

      data.data.forEach((stock, index) => {
        const div = document.createElement("div");
        div.className = "formGroup col-md-12 border mb-3";
        div.dataset.index = stock.product_id;
        this.countterForm();
        div.innerHTML = `
            <div class="col-md-12" >
              <div class=row col-12">
              <button type="button" class="remove-btn-2 ml-auto my-2" data-index="${stock.product_id}">❌ ลบ</button>
              </div>
              <input type="hidden" name="product_id[]" value="${stock.product_id}" />
              <div class="form-group mb-2">
                <label class="mt-0 mb-0 font-weight-bold text-dark"></label>
                <div class="customInputContainer">
                    <div class="customInput searchInput">
                        <input class="selectedData form-control u_product_name" value="${stock.product_name}" type="text" name="product_name[]" required/>
                    </div>
                    <div class="options">
                        <ul></ul>
                    </div>
                </div
              </div>  
            </div>
            <div class="col-md-12 row">
              <div class="col-md-5">
                <div class="form-group mb-2">
                  <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
                  <input type="text" class="u_count_product form-control" name="count_product[]" value="${stock.product_count}" placeholder="ชื่อสินค้า" required>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label class="mt-0 mb-0 font-weight-bold text-dark">ต้นทุนต่อชิ้น</label>
                    <input type="text" class="u_price_product form-control" name="price_product[]" value="${stock.product_price}"  placeholder="ต้นทุนต่อชิ้น" required>
                  </div>
              </div>
              <div class="col-md-3 align-self-center">
                  <div class="form-group mb-2">
                    <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
                    <input type="text" class="u_expenses form-control" name="expenses[]" value="${stock.expenses}" placeholder="ค่าใช้จ่าย" required>
                  </div>
              </div>
            </div>`;
        container.appendChild(div);
        let product_name = div.querySelector(".u_product_name");
        let count_product = div.querySelector(".u_count_product");
        let price_product = div.querySelector(".u_price_product");
        let expenses = div.querySelector(".u_expenses");
        product_name.id = `e-product_name-${index}`;
        count_product.id = `e-count_product-${index}`;
        price_product.id = `e-price_product-${index}`;
        expenses.id = `e-expenses-${index}`;

        count_product.addEventListener("input", (e) => {
          let value = e.target.value;
          console.log("t=", expenses.value);
          price_product.value = Number((expenses.value / value).toFixed(2));
          updateGrandTotal(this.financedata);
        });

        price_product.addEventListener("input", (e) => {
          let value = e.target.value;
          expenses.value = Number((count_product.value * value).toFixed(2));
          updateGrandTotal(this.financedata);
        });

        expenses.addEventListener("input", (e) => {
          let value = e.target.value;
          price_product.value = Number(
            (value / count_product.value).toFixed(2)
          );
          updateGrandTotal(this.financedata);
        });
        container.addEventListener("click", (e) => {
          if (e.target.classList.contains("remove-btn-2")) {
            const index = e.target.dataset.index;
            const targetDiv = document.querySelector(`[data-index="${index}"]`);
            if (targetDiv) targetDiv.remove();
            updateGrandTotal(this.financedata);
          }
        });
      });
    } catch (e) {
      console.error(`"Error loading orders:, ${e}`);
    }
  }

  scripts() {
    const containers = document.getElementById("formupdateorder");

    document.getElementById("add-form-update").addEventListener("click", () => {
      const divs = document.createElement("div");
      divs.className = "formGroup col-md-12 border mb-3";

      divs.innerHTML = uiFormUpdate;
      containers.appendChild(divs);

      divs.querySelector(".remove-btn").addEventListener("click", () => {
        divs.remove();
        this.countterForm();
        //updateGrandTotal();
      });
      this.countterForm();
    });
  }
  renderUpdateOrder() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl " id="modalFormUpdateOrder" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header px-4">
              <h5 class="modal-title row mx-4" id="exampleModalLongTitle">สินค้าที่สั่งซื้อ</p></h5>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="form_update" method="post" action="backend/create_order.php" enctype="multipart/form-data">
              <input type="hidden" name="status_form" value="update" />
              <input type="hidden" name="order_id" id="order_id" />
              <input type="hidden" name="default_img" id="img_default"/>
              <div class="modal-body">
                <div class="mt-2 row">
                  <div class="col-md-8">
                      <div class="col-md-12">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">รายการคำสั่งซื้อ</label>
                          <input type="text" class="form-control" name="order_name" id="order_name" placeholder="รายการคำสั่งซื้อ" required>
                        </div> 
                      </div>

                      <div class="col-md-12 row">
                        <div class="col-md-7">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
                            <input type="text" class="form-control" name="totalcost_order" id="totalcost_orders" placeholder="ค่าใช้จ่าย" required>
                          </div> 
                        </div>
                        <div class="col-md-5 row"> 
                          <div class="form-group">
                            <label class="mt-0 mb-0 font-weight-bold text-dark align-self-center mt-4">บาท</label>
                          </div>
                        </div>
                        
                      </div>
                      <div class="col-md-12">
                      <div class="form-group">
                        <label class="mt-0 mb-0 font-weight-bold text-dark align-self-center">
                          <span class="text-primary px-2" id="defult-price"></span>
                          <span class="px-2" id="u_funds_that_can_be_used"></span> 
                          <span class="px-2" id="add-price"></span>
                        </label>
                      </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">วันที่และเวลา</label>
                          <input type="datetime-local" class="form-control" name="date_time_order" id="date_time_order" placeholder="วันที่และเวลา" required>
                        </div> 
                      </div>
                  </div>
                  <div class="col-md-4">
                    <mian-add-image id="slipt_order" count="order_Slip" wrapper="ux-wrap" filenames="uimgname" cancles="ux-cancle"
                      names="รูปโปรไฟล์" custom="btn_custom" setdefault="setDefaultImgOrder"></mian-add-image>
                  </div>
                </div>
                
                <div id="formupdateorder"></div>
                
                <div class="col-md-12 row mt-4">
                  <button type="button" class="btn btn-sm btn-success ml-auto mr-4" id="add-form-update">เพิ่ม สินค้า</button>
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
customElements.define("main-update-order", modelUpdateOrder);

$(document).on("click", "#update_order", function (e) {
  let product_id = $(this).data("id");
  let comp = document.querySelector("main-update-order");
  comp.dispatchEvent(new CustomEvent("setId", { detail: product_id }));
  const container = document.querySelector("#formupdateorder");
  if (container) container.innerHTML = "";

  $product_ids = $(this).data("id");
  $order_name = $(this).data("ordername");
  $total_cost = $(this).data("totalcost");

  $priceorder = $(this).data("priceorder");
  $slipimage = $(this).data("slipimage");
  $dateorder = $(this).data("dateorder");
  $("#order_id").val($product_ids);
  $("#order_name").val($order_name);
  $("#totalcost_orders").val($total_cost);
  $("#defult-price").html(`เดิม ${$total_cost} บาท`);
  $("#priceorder").html($priceorder);
  $("#date_time_order").val($dateorder);
  $("#img_default").val($slipimage);

  e.preventDefault();
  $("#slip_order").val($slipimage);
  $(".slipt_order").attr("src", `../db/slip-orders/${$slipimage}`);
  $(".ux-wrap").last().addClass("active");
  $(".uimgname").html($slipimage);
});

$(document).on("click", "#confirmTrashOrder", function (e) {
  let ID = $(this).data("id");
  let ordername = $(this).data("ordername");
  Swal.fire({
    title: "คุณแน่ใจไหม ?",
    text: `รายการ ${ordername} นี้ พร้อมสินค้า จะถูกลบทั้งหมด จะไม่สามารถย้อนกลับได้`,
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
          `http://localhost/stockproduct/system/backend/api/order.php?order_id=${ID}`,
          {
            method: "DELETE",
            credentials: "include",
          }
        );
        const responsedata = await responseapi.json();
        console.log("s=", responsedata.status);
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
        throw new Error(`Is Delete Error : ${e}`);
      }
    }
  });
});
