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

$(document).on("click", "#set_rate_price", function (e) {
  $rate_id = $(this).data("id");
  $product_name = $(this).data("product");
  $productprice = $(this).data("productprice");
  $rate_price_storefront = $(this).data("storefront");
  $rate_price_vip = $(this).data("vip");
  $rate_price_dealers = $(this).data("dealers");
  $rate_price_delivery = $(this).data("delivery");
  $("#rate_id").val($rate_id);
  $("#product_name").val($product_name);
  $("#rate_price_vip").val($rate_price_vip);
  $("#rate_price_storefront").val($rate_price_storefront);
  $("#rate_price_dealers").val($rate_price_dealers);
  $("#rate_price_delivery").val($rate_price_delivery);
  $("#productname").html($product_name);
  $("#productnames").html($product_name);
  $("#productprice").html($productprice);
  e.preventDefault();
});

class modelCreateRatePrice extends HTMLElement {
  connectedCallback() {
    this.renderCreatePrice();
  }
  renderCreatePrice() {
    this.innerHTML = `
    <div class="modal fade bd-example-modal-xl" id="modalFormUpdateRate" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มเรทราคา <span id="productname"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="myForm" method="POST" action="../backend/product_stock.php">
              <input type="hidden" name="status_form" value="create_rate" />
              <input type="hidden" name="rate_id" id="rate_id" />
              <input type="hidden" name="product_name" id="product_name" />
              <div class="modal-body">
                  <div class="col-md-12 row mb-3">
                    <div class="col-md-6">
                      <div class="form-group mb-2">
                        <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา หน้าร้าน</label>
                        <input type="text" class="form-control" name="rate_storefront" id="rate_price_storefront" placeholder="ชื่อสินค้า" required>
                      </div>  
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา วีไอพี่</label>
                          <input type="text" class="form-control" name="rate_vip" id="rate_price_vip" placeholder="ชื่อสินค้า" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา ตัวแทนจำหน่าย</label>
                          <input type="text" class="form-control" name="rate_dealers" id="rate_price_dealers" placeholder="ชื่อสินค้า" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">ราคา จัดส่ง</label>
                          <input type="text" class="form-control" name="rate_delivery" id="rate_price_delivery" placeholder="ชื่อสินค้า" required>
                        </div>
                    </div>
                    <div class="col-md-12 align-self-center row mt-4">
                        <div class="col-md-6 " id="name_product">
                            ชื่อสินค้า : <span id="productnames" class="font-weight-bold text-danger"></span>
                        </div>
                        <div class="col-md-6" >
                          ราคาต้นทุนชื้นละ : <span id="productprice" class="font-weight-bold text-danger"></span> บาท
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
customElements.define("main-rate-price", modelCreateRatePrice);

class modelUpdateStock extends HTMLElement {
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
      // data.data.forEach((stock, index) => {

      // });
    } catch (e) {
      console.error(`"Error loading orders:, ${e}`);
    }
  }
  renderUpdateOrder() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl " id="modalFormUpdateRate2" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
              <input type="text" id="id_stock" name="stock_id"/>
              <div class="modal-body">
                <div class="mt-2 row border">
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
customElements.define("main-update-stock", modelUpdateStock);

$(document).on("click", "#update_product", function (e) {
  const product_id = $(this).data("id");
  const product_name = $(this).data("name");
});
