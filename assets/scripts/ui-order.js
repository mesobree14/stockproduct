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

const setImagePriviews = (
  getImage,
  setDefaultFile,
  setCustomBtn,
  btnCancle,
  getImgNames,
  setWrapper
) => {
  let setwrapper = document.querySelector(setWrapper);
  let setImgName = document.querySelector(getImgNames);
  let setBtncancle = document.querySelector(btnCancle);
  let typeImg = document.querySelector(getImage);
  let defaultInput = document.querySelector(setDefaultFile);
  let CustomButton = document.querySelector(setCustomBtn);
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
};

const uiForm = `    
      <div class="col-md-12">
        <div class=row col-12">
        <button type="button" class="remove-btn ml-auto">❌ ลบ</button>
        </div>
        <div class="form-group mb-2">
          <label class="mt-0 mb-0 font-weight-bold text-dark labelCount"></label>
          <input type="text" class="form-control" name="product_name[]" id="" placeholder="ชื่อสินค้า" required>
        </div>  
      </div>
      <div class="col-md-12 row">
        <div class="col-md-5">
          <div class="form-group mb-2">
            <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
            <input type="text" class="form-control" name="count_product[]" id="" placeholder="ชื่อสินค้า" required>
          </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-2">
              <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา</label>
              <input type="text" class="form-control" name="price_product[]" id="" placeholder="ชื่อสินค้า" required>
            </div>
        </div>
        <div class="col-md-3 align-self-center">
            ราคารวม 34500
        </div>
      </div>
    `;

class modelCreateOrder extends HTMLElement {
  connectedCallback() {
    this.renderCreateOrder();
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
                          <input type="text" class="form-control" name="order_name" id="" placeholder="รายการคำสั่งซื้อ" required>
                        </div> 
                      </div>

                      <div class="col-md-12 row">
                        <div class="col-md-7">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ค่าใช้จ่าย</label>
                            <input type="text" class="form-control" name="totalcost_order" id="" placeholder="ค่าใช้จ่าย" required>
                          </div> 
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label class="mt-0 mb-0 font-weight-bold text-dark align-self-center mt-4">บาท</label>
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
                        <input type="text" class="form-control" name="product_name[]" id="" placeholder="ชื่อสินค้า" required>
                      </div>  
                    </div>
                    <div class="col-md-12 row">
                      <div class="col-md-5">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
                          <input type="text" class="form-control" name="count_product[]" id="" placeholder="ชื่อสินค้า" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา</label>
                            <input type="text" class="form-control" name="price_product[]" id="" placeholder="ชื่อสินค้า" required>
                          </div>
                      </div>
                      <div class="col-md-3 align-self-center">
                          ราคารวม 34500
                      </div>
                    </div>
                </div>
                </div>
                <div class="col-md-12 row mt-4">
                  <button type="button" class="col-md-5 btn btn-sm btn-success ml-auto mr-4" id="add-form">เพิ่ม สินค้า</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success ml-auto mr-4">บันทึกข้อมูล</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    `;
  }
}
customElements.define("main-create-order", modelCreateOrder);
const container = document.getElementById("formcreateorder");
function CountForm() {
  const group = container.querySelectorAll(".formGroup");

  group.forEach((group, index) => {
    let label = group.querySelector("label");
    label.textContent = `ชื่อสินค้าตัวที่ ${index + 1}`;
  });
}

document.getElementById("add-form").addEventListener("click", function () {
  const div = document.createElement("div");
  div.className = "formGroup col-md-12 border mb-3";
  div.innerHTML = uiForm;
  container.appendChild(div);

  // ผูก event ปุ่มลบ
  div.querySelector(".remove-btn").addEventListener("click", function () {
    div.remove();
    CountForm();
  });
  CountForm();
});
CountForm();
setImagePriviews(
  ".orphanImage",
  ".setDefaultImgOrphan",
  "#setbtnCustomX",
  ".x-cancleX i",
  ".ximgnameX",
  ".x-wrapX"
);

class modelUpdateOrder extends HTMLElement {
  connectedCallback() {
    this.addEventListener("setId", (e) => {
      this.productId = e.detail;
      this.loadOrder(this.productId);
    });
    this.renderUpdateOrder();
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

      const container = document.getElementById("formupdateorder");
      data.data.forEach((stock, index) => {
        const div = document.createElement("div");
        div.className = "formGroup col-md-12 border mb-3";
        div.dataset.index = stock.product_id;
        div.innerHTML = `
            <div class="col-md-12" >
              <div class=row col-12">
              <button type="button" class="remove-btn-2 ml-auto" data-index="${
                stock.product_id
              }">❌ ลบ</button>
              </div>
              <div class="form-group mb-2">
                <label class="mt-0 mb-0 font-weight-bold text-dark">ชื่อสินค้าตัวที่ ${
                  index + 1
                }</label>
                <input type="text" class="form-control" name="product_name[]" value="${
                  stock.product_name
                }" id="" placeholder="ชื่อสินค้า" required>
              </div>  
            </div>
            <div class="col-md-12 row">
              <div class="col-md-5">
                <div class="form-group mb-2">
                  <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวน</label>
                  <input type="text" class="form-control" name="count_product[]" value="${
                    stock.product_count
                  }"  id="" placeholder="ชื่อสินค้า" required>
                </div>
              </div>
              <div class="col-md-4">
                  <div class="form-group mb-2">
                    <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา</label>
                    <input type="text" class="form-control" name="price_product[]" value="${
                      stock.product_price
                    }"  id="" placeholder="ชื่อสินค้า" required>
                  </div>
              </div>
              <div class="col-md-3 align-self-center">
                  ราคารวม ${
                    Number(stock.product_price) * Number(stock.product_count)
                  }
              </div>
            </div>`;
        container.appendChild(div);
        container.addEventListener("click", (e) => {
          if (e.target.classList.contains("remove-btn-2")) {
            const index = e.target.dataset.index;
            const targetDiv = document.querySelector(`[data-index="${index}"]`);
            if (targetDiv) targetDiv.remove();
          }
        });
      });
    } catch (e) {
      console.error(`"Error loading orders:, ${e}`);
    }
  }
  renderUpdateOrder() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl " id="modalFormUpdateOrder" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title row" id="exampleModalLongTitle">สินค้าที่สั่งซื้อ</p></h5>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="form_update" method="post" action="backend/create_order.php" enctype="multipart/form-data">
              <input type="hidden" name="status_form" value="update" />
              <div class="modal-body">
                <div class="mt-2 row border">
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
                            <input type="text" class="form-control" name="totalcost_order" id="totalcost_order" placeholder="ค่าใช้จ่าย" required>
                          </div> 
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <label class="mt-0 mb-0 font-weight-bold text-dark align-self-center mt-4">บาท</label>
                          </div>
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
                    <mian-add-image id="slipt_order" count="orderSlip" wrapper="ux-wrap" filenames="uimgname" cancles="ux-cancle"
                      names="รูปโปรไฟล์" custom="btn_custom" setdefault="setDefaultImgOrder"></mian-add-image>
                  </div>
                </div>
                
                <div id="formupdateorder"></div>
                
                <div class="col-md-12 row mt-4">
                  <button type="button" class="col-md-5 btn btn-sm btn-success ml-auto mr-4" id="add-form-update">เพิ่ม สินค้า</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success ml-auto mr-4">บันทึกข้อมูล</button>
              </div>
            </form>
            
          </div>
        </div>
      </div>
    `;
  }
}
customElements.define("main-update-order", modelUpdateOrder);
const containers = document.getElementById("formupdateorder");
// function CountForm() {
//   const group = containers.querySelectorAll(".formGroup");

//   group.forEach((group, index) => {
//     let label = group.querySelector("label");
//     label.textContent = `ชื่อสินค้าตัวที่ ${index + 1}`;
//   });
// }
document
  .getElementById("add-form-update")
  .addEventListener("click", function () {
    const divs = document.createElement("div");
    divs.className = "formGroup col-md-12 border mb-3";
    divs.innerHTML = uiForm;
    containers.appendChild(divs);

    // ผูก event ปุ่มลบ
    divs.querySelector(".remove-btn").addEventListener("click", function () {
      divs.remove();
      CountForm();
    });
    CountForm();
  });

$(document).on("click", "#update_order", function (e) {
  let product_ids = $(this).data("id");
  let comp = document.querySelector("main-update-order");
  comp.dispatchEvent(new CustomEvent("setId", { detail: product_ids }));
  const container = document.querySelector("#formupdateorder");
  if (container) container.innerHTML = "";
  console.log({ container });

  $product_id = $(this).data("id");
  $order_name = $(this).data("ordername");
  $totalcost = $(this).data("totalcost");
  $priceorder = $(this).data("priceorder");
  $slipimage = $(this).data("slipimage");
  $dateorder = $(this).data("dateorder");
  $("#productId").val($product_id);
  $("#order_name").val($order_name);
  $("#totalcost_order").val($totalcost);
  $("#priceorder").html($priceorder);
  $("#date_time_order").val($dateorder);

  e.preventDefault();
  $("#slip_order").val($slipimage);
  $(".slipt_order").attr("src", `../db/slip-orders/${$slipimage}`);
  $(".ux-wrap").last().addClass("active");
  $(".uimgname").html($slipimage);
});

setImagePriviews(
  ".slipt_order",
  ".setDefaultImgOrder",
  "#btn_custom",
  ".ux-cancle i",
  ".uimgname",
  ".ux-wrap"
);
