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

// function updateData(data) {
//   console.log({ data });
//   let selectedCountry = data.innerText;
//   console.log({ selectedCountry });
//   selectedDatas.value = selectedCountry;

//   for (const li of document.querySelectorAll("li.selected")) {
//     li.classList.remove("selected");
//   }
//   data.classList.add("selected");
//   customInputContainer.classList.toggle("show");
//   console.log(selectedCountry);
// }
customElements.define("mian-add-image", AddImage);
class modelSetOrderSell extends HTMLElement {
  stockdata = [];

  constructor() {
    super();
    this.countries = ["Thailand", "Japan", "USA"];
  }

  async connectedCallback() {
    await this.loadDataStock();
    this.renderCreateOrderSell();
    this.loadOption();
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

  updateData(data) {
    console.log({ data });
    let selectedCountry = data.innerText;
    console.log({ selectedCountry });
    selectedDatas.value = selectedCountry;

    for (const li of document.querySelectorAll("li.selected")) {
      li.classList.remove("selected");
    }
    data.classList.add("selected");
    customInputContainer.classList.toggle("show");
    console.log(selectedCountry);
  }

  loadOption() {
    console.log("f=", this.stockdata);
    var productname = this.stockdata.map((item) => item.product_name);
    //var countries = ["Custom Input", "Afghanistan", "Aland Islands", "Albania"];
    console.log({ x: productname[0] });
    let customInput = document.querySelector(".customInput");
    let selectedData = document.querySelector(".selectedData");
    let searchInput = document.querySelector(".searchInput input");

    let ul = document.querySelector(".options ul");
    let customInputContainer = document.querySelector(".customInputContainer");
    window.addEventListener("click", (e) => {
      //updateData(e.target);
      if (document.querySelector(".searchInput").contains(e.target)) {
        document.querySelector(".searchInput").classList.add("focus");
      } else {
        document.querySelector(".searchInput").classList.remove("focus");
      }

      if (!customInputContainer.contains(e.target)) {
        customInputContainer.classList.remove("show");
      }
    });

    customInput.addEventListener("click", () => {
      customInputContainer.classList.toggle("show");
    });

    let countriesLength = productname.length; //co.length;

    for (let i = 0; i < countriesLength; i++) {
      let country = productname[i];
      const li = document.createElement("li");
      const countryName = document.createTextNode(country);
      li.appendChild(countryName);
      ul.appendChild(li);
    }

    ul.querySelectorAll("li").forEach((li) => {
      li.addEventListener("click", (e) => {
        let selectdItem = e.target.innerText;
        selectedData.value = selectdItem;

        for (const li of document.querySelectorAll("li.selected")) {
          li.classList.remove("selected");
        }
        e.target.classList.add("selected");
        customInputContainer.classList.toggle("show");
      });
    });
    searchInput.addEventListener("keyup", (e) => {
      let searchedVal = searchInput.value.toLowerCase();
      let searched_country = productname.filter((data) =>
        data.toLowerCase().startsWith(searchedVal)
      );
      ul.innerHTML = "";
      if (searched_country.length === 0) {
        ul.innerHTML = `<p style='margin-top: 1rem;'>
                          Opps can't find any result 
                          <p style='margin-top: .2rem; font-size: .9rem;'>Try searching something else.</p>
                        </p>`;
        return;
      }
      searched_country.forEach((contry) => {
        const li = document.createElement("li");
        li.textContent = contry;
        li.addEventListener("click", () => this.updateData(contry));
        ul.appendChild(li);
      });
    });

    // searchInput.addEventListener("keyup", (e) => {
    //   let searchedVal = searchInput.value.toLowerCase();
    //   let searched_country = [];

    //   //searched_country = response.data //countries
    //   searched_country = countries
    //     .filter((data) => {
    //       return data.toLocaleLowerCase().startsWith(searchedVal);
    //     })
    //     .map((data) => {
    //       return `<li onClick="updateData(this)">${data}</li>`;
    //     })
    //     .join("");
    //   ul.innerHTML = searched_country
    //     ? searched_country
    //     : "<p style='margin-top: 1rem;'>Opps can't find any result <p style='margin-top: .2rem; font-size: .9rem;'>Try searching something else.</p></p>";
    // });
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
                <form id="myForm" method="POST" action="../backend/product_stock.php">
                  <input type="hidden" name="status_form" value="create" />
                  <div class="modal-body">
                      <div class="col-md-12 row mb-3">
                        <div class="col-md-8">
                          <div class="form-group mb-2">
                            <label class="mt-0 mb-0 font-weight-bold text-dark col-12">รายการสินค้า</label>

                              <div class="customInputContainer">
                                <div class="customInput searchInput">
                                    <input class="selectedData form-control"  type="text" />
                                </div>
                                <div class="options">
                                    <ul></ul>
                                </div>
                            </div>  
                          </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                              xxxxx
                        </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
    `;
  }
}

customElements.define("mian-form-ordersell", modelSetOrderSell);

var countries2 = ["Custom Input", "Afghanistan", "Aland Islands"];
