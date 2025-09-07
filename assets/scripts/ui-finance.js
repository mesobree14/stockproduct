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

class Capital extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.renderHTML();
  }
  renderHTML() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl" id="modalFormCapital" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มเรทราคา <span id="productname"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form  method="POST" action="backend/finance.php" enctype="multipart/form-data">
              <input type="hidden" name="status_form" value="capital"/>
              <div class="modal-body">
                <div class="modal-body">
                    <div class="col-md-12 row mb-3">
                      <div class="col-md-7">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวนทุน / .บ</label>
                          <input type="text" class="form-control" name="count_capital" id="count_capital" placeholder="ชื่อสินค้า" required>
                        </div>  
                      </div>
                      <div class="col-md-5">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">เวลา</label>
                            <input type="datetime-local" class="form-control" name="date_time_capital" id="date_time_capital" placeholder="วันที่และเวลา" required>
                          </div>
                      </div>
                      <div class="col-md-7">
                        
                      </div>
                      <div class="col-md-5">
                          <mian-add-image id="slip_capital" count="capital_slip" wrapper="ux-wrap" filenames="uimgname" cancles="ux-cancle"
                            names="รูปโปรไฟล์" custom="btn_custom" setdefault="setDefaultImgCapital"></mian-add-image>
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

customElements.define("main-create-capital", Capital);

class Withdraw extends HTMLElement {
  constructor() {
    super();
  }
  connectedCallback() {
    this.renderHTML();
  }
  renderHTML() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl" id="modalFormWithdraw" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มเรทราคา <span id="productname"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form  method="POST" action="backend/finance.php" enctype="multipart/form-data">
              <input type="hidden" name="status_form" value="withdraw"/>
              <div class="modal-body">
                <div class="modal-body">
                    <div class="col-md-12 row mb-3">
                      <div class="col-md-7">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวนเงินที่เบิกถอน / .บ</label>
                          <input type="text" class="form-control" name="count_withdraw" id="rate_price_storefront" placeholder="ชื่อสินค้า" required>
                        </div>  
                      </div>
                      <div class="col-md-5">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">เวลา</label>
                            <input type="datetime-local" class="form-control" name="date_time_withdraw" id="date_time_withdraw" placeholder="วันที่และเวลา" required>
                          </div>
                      </div>
                      <div class="col-md-7">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">เหตุผลในการเบิกถอน</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="reason" rows="3"></textarea>
                        </div>
                      </div>
                      <div class="col-md-5">
                          <mian-add-image id="slip_withdraw" count="withdraw_slip" wrapper="ux-wrap" filenames="uimgname-withdraw" cancles="ux-cancle"
                            names="รูปโปรไฟล์" custom="btn_custom_withdraw" setdefault="setDefaultImgWithDraw"></mian-add-image>
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

customElements.define("main-create-withdraw", Withdraw);
