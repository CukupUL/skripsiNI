let Penjualan = {
  listSearchProduct: [],
  baseUrl: window.location.origin,
  indexRow: 1,
  choiceProduk: [],
  listChoiceProduk: [],

  totalOrder: 0,
  totalPayment: 0,

  delay(fn, ms) {
    let timer;
    return function(...args) {
      clearTimeout(timer)
      timer = window.setTimeout(fn.bind(this, ...args), ms || 0)
    }
  },

  checkSubmit() {
    if (Penjualan.totalOrder > 0) {
      if (Penjualan.totalPayment >= Penjualan.totalOrder) {
        document.querySelector("#formPenjualan").submit();
      } else {
        alert("Pembayaran tidak mencukupi");
      }
    } else {
      alert("Anda belum memasukan barang!");
    }
  },

  hideResult() {
    let listResults = document.querySelectorAll(".listSearch");

    listResults.forEach(result => {
      result.innerHTML = "";
    });
  },

  initSearchProduct() {
    document.querySelector("#inputKodeProduk").addEventListener("keyup", Penjualan.delay(function() {
      Penjualan.searchProduct();
    }, 1000));
    document.querySelector("#inputKodeProduk").addEventListener("blur", Penjualan.delay(function() {
      Penjualan.hideResult();
    }, 500));
  },

  async searchProduct() {
    Penjualan.listSearchProduct = [];
    let kodeProduk = document.querySelector("#inputKodeProduk").value;
    
    let request = await fetch(`${Penjualan.baseUrl}/penjualan/produk/search?kode=${kodeProduk}`);

    if (request.ok) {
      let response = await request.json();
      if (response.status) {
        Penjualan.listSearchProduct = response.data;
      }
      Penjualan.renderSearchProduct();
    }
  },

  renderSearchProduct() {
    let template = document.querySelector("#templateSearchProduk");
    let html = "";

    if (Penjualan.listSearchProduct.length > 0) {
      Penjualan.listSearchProduct.forEach(item => {
        html += `<p onclick="Penjualan.choicedProduct('${item.id_produk}')">${item.kode_produk} - ${item.nama_produk} - ${item.tgl_exp}</p>`;
      });
    } else {
      html += `<p>Produk tidak ditemukan!</p>`;
    }

    template.innerHTML = html;
  },

  numberFormat(value) {
    if (value != null) {
      if (value.toString()[0] == "-") {
        var negative = "-";
      } else {
        negative = "";
      }
      var raw = value.toString().replace(/(?!\.)\D/g, "").split(".");
      var whole = raw[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      var decimal = false;
      var number = "";
      if (raw.length > 1) {
        decimal = raw[1];
      }
      if (decimal !== false && (decimal !== "0" || decimal !== "00")) {
        number = negative + whole + "." + decimal;
      } else {
        number = negative + whole;
      }

      return number.replace(".", "");
    }
  },

  bindNumberFormat() {
    let listInputNumber = document.querySelectorAll(".number-format");
    for (let i = 0; i < listInputNumber.length; i++) {
      listInputNumber[i].addEventListener("keyup", function(e) {
        if (e.keyCode !== 6 && e.keyCode !== 46) {
          this.value = Penjualan.numberFormat(this.value);
        }
      });
    }
  },

  deleteComma(value) {
    return value.toString().replace(/,/g, "");
  },

  choicedProduct(idProduk) {
    let findProduk = Penjualan.listSearchProduct.find(item => item.id_produk == idProduk);
    
    if (findProduk) {
      Penjualan.choiceProduk = findProduk;
      Penjualan.renderChoiceProduk();
    }
  },

  renderChoiceProduk() {
    let html = Penjualan.templateRowProduk(Penjualan.choiceProduk);
    document.querySelector("#templateListProduk").insertAdjacentHTML("beforeend", html);
    Penjualan.bindNumberFormat();
    Penjualan.reIndexRow();
    Penjualan.calculateAll();
  },

  templateRowProduk(data) {
    let html = "";
    html += `<tr class="list-row">`;
    html += `<td class="index-row">${Penjualan.indexRow}</td>`;
    html += `<td>${data.kode_produk}</td>`;
    html += `<td>${data.nama_produk}</td>`;
    html += `<td>${Penjualan.numberFormat(data.harga_jual)}</td>`;
    html += `<td>`;
    html += `<input type="text" onblur="Penjualan.calculateAll()" class="form-control number-format input-jumlah" name="jumlah[]" value="${data.jumlah ?? '1'}">`;
    html += `<input type="hidden" name="id_produk[]" value="${data.id_produk}">`;
    html += `<input type="hidden" class="input-harga-jual" value="${data.harga_jual}" name="harga_jual[]">`;
    html += `</td>`;
    html += `<td class="info-subtotal">${Penjualan.numberFormat(data.harga_jual)}</td>`;
    html += `<td><button class="btn btn-danger btn-sm btn-delete">Hapus</button></td>`;
    html += `</tr>`;

    return html;
  },

  calculate() {
    let listJumlah = document.querySelectorAll(".input-jumlah");
    let listHargaJual = document.querySelectorAll(".input-harga-jual");
    let listSubTotal = document.querySelectorAll(".info-subtotal");
    let total = 0;

    for (let i = 0; i < listJumlah.length; i++) {
      let jumlah = parseInt(Penjualan.deleteComma(listJumlah[i].value));
      let hargaJual = parseInt(Penjualan.deleteComma(listHargaJual[i].value));
      let subtotal = parseInt(jumlah * hargaJual);

      listSubTotal[i].innerHTML = Penjualan.numberFormat(subtotal);
      total += subtotal;
    }

    Penjualan.totalOrder = total;
    document.querySelector("#inputTotalHarga").value = Penjualan.numberFormat(total);
  },

  calculateAll() {
    Penjualan.calculate();
    let inputBayar = parseInt(Penjualan.deleteComma(document.querySelector("#inputBayar").value));
    Penjualan.totalPayment = inputBayar;
    document.querySelector("#inputDiterima").value = isNaN(inputBayar) ? 0 : Penjualan.numberFormat(inputBayar);

    let kembalian = inputBayar - Penjualan.totalOrder;
    document.querySelector("#inputKembalian").value = isNaN(kembalian) ? 0 : Penjualan.numberFormat(kembalian);
  },

  reIndexRow() {
    let listRow = document.querySelectorAll(".index-row");
    let lisBtnDelete = document.querySelectorAll(".btn-delete");
    let listTrRow = document.querySelectorAll(".list-row");

    for (let i = 0; i < listRow.length; i++) {
      listRow[i].innerHTML = i + 1;
      listTrRow[i].setAttribute("id", "row-" + (i + 1));
      lisBtnDelete[i].setAttribute("onclick", `Penjualan.deleteRow('${i + 1}')`);
    }
  },

  deleteRow(index) {
    let row = document.querySelector("#row-" + index);
    row.remove();
    Penjualan.reIndexRow();
  }
};

Penjualan.initSearchProduct();
Penjualan.bindNumberFormat();