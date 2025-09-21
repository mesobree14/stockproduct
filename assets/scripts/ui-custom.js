$(function () {
  var $tabButtonItem = $("#tab-button-custom li"),
    $tabSelect = $("#tab-select-custom"),
    $tabContents = $(".tab-contents"),
    activeClass = "is-active";

  $tabButtonItem.first().addClass(activeClass);
  $tabContents.not(":first").hide();

  $tabButtonItem.find("a").on("click", function (e) {
    var target = $(this).attr("href");

    $tabButtonItem.removeClass(activeClass);
    $(this).parent().addClass(activeClass);
    $tabSelect.val(target);
    $tabContents.hide();
    $(target).show();
    e.preventDefault();
  });

  $tabSelect.on("change", function () {
    var target = $(this).val(),
      targetSelectNum = $(this).prop("selectedIndex");

    $tabButtonItem.removeClass(activeClass);
    $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
    $tabContents.hide();
    $(target).show();
  });
});

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

class ModelPayOffDebt extends HTMLElement {
  connectedCallback() {
    this.renderUi();
    this.script();
    this.generateID();
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
    document.getElementById("serial_number").value = id;
  }

  script() {
    let count_paydebt = document.getElementById("count_paydebt");
    let count_debt = document.getElementById("count_debt");
    let debtpaid_balance = document.getElementById("debtpaid_balance");
    let debtpaid_balance_html = document.getElementById(
      "debtpaid_balance_html"
    );
    count_paydebt.addEventListener("input", function () {
      let result = Number(count_debt.textContent) - Number(count_paydebt.value);
      debtpaid_balance.value =
        debtpaid_balance_html.textContent = `เหลืออีก ${result} บาท`;
      console.log(
        count_paydebt.value,
        " : ",
        count_debt.textContent - count_paydebt.value
      );
    });
  }
  renderUi() {
    this.innerHTML = `
      <div class="modal fade bd-example-modal-xl" id="modalFormPayOffDebt" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content" id="">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มการจ่ายหนี้ของ <span id="customname"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form  method="POST" action="../backend/customer.php" enctype="multipart/form-data">
              <input type="hidden" name="type_page" id="type_page"/>
              <input type="hidden" name="customer_name" id="customer_name" />
              <input type="hidden" name="debtpaid_balance" id="debtpaid_balance" />
              <input type="hidden" name="serial_number" id="serial_number" />
              <div class="modal-body">
                <div class="modal-body">
                    <div class="col-md-12 row mb-3">
                    <div class="col-md-7 row py-2">
                        <span class=" text-primary font-weight-bold">จำนวนหนี้ที่ <span id="custom_name"></span> เหลืออยู่ <span id="count_debt"></span> บาท</span>
                      </div>
                      <div class="col-md-5"></div>
                      <div class="col-md-7">
                        <div class="form-group mb-2">
                          <label class="mt-0 mb-0 font-weight-bold text-dark">จำนวนเงินที่ต้องการจ่าย / .บ  <span id="debtpaid_balance_html" class="text-success"></span></label>
                          <input type="text" class="form-control" name="count_paydebt" id="count_paydebt" placeholder="จำนวนเงิน" required>
                        </div>  
                      </div>
                      <div class="col-md-5">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark">เวลา</label>
                            <input type="datetime-local" class="form-control" name="date_add" id="date_add" placeholder="วันที่และเวลา" required>
                          </div>
                      </div>
                      <div class="col-md-7">
                        
                          <label class="mt-0 mb-0 col-12 font-weight-bold text-dark">ตัวเลือกการจ่าย <span class="text-danger">*</span></label>
                          <select class="form-control multiple-select" name="payment_option[]" id="payment_options" placeholder="ตัวเลือกการจ่าย" multiple="multiple" required>
                            <option value="โอน">โอน</option>
                            <option value="จ่ายสด">จ่ายสด</option>
                          </select>
                       
                          <label for="exampleFormControlTextarea1">เหตุผล(ถ้ามี)</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="orther_text" rows="4"></textarea>
                        
                      </div>
                      <div class="col-md-5">
                          <mian-add-image id="slip_payoffdebt" count="payoffdebt_slip" wrapper="ux-wrap" filenames="uimgname" cancles="ux-cancle"
                            names="หลักฐานโอนเงิน" custom="btn_payoffdebt" setdefault="setDefaultImgCapital"></mian-add-image>
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

customElements.define("main-pay-debt", ModelPayOffDebt);

$(document).on("click", "#modelpayoff_debt", function (e) {
  e.preventDefault();
  let typepage = $(this).data("types");
  let customname = $(this).data("custome");
  let countdebt = $(this).data("debt");
  console.log({ customname });

  $("#customer_name").val(customname);
  $("#type_page").val(typepage);
  $("#customname").html(customname);
  $("#custom_name").html(customname);
  $("#count_debt").html(countdebt);
});
