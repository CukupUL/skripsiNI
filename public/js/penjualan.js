let Penjualan = {
  //menyimoan data produk untuk dicaro
  listSearchProduct: [],
  //url saat ini
  baseUrl: window.location.origin,
  //untuk menndakan baris keberapa
  indexRow: 1,
  //mengambil prodak yanag iambil
  choiceProduk: [],
  //properti untuk menyimpan produkyanag dipilih
  listChoiceProduk: [],
  //untuk menyimpan total tagihan
  totalOrder: 0,
  //total untuk penyimpaann yng iudah dibayar
  totalPayment: 0,
//untuk delay
  delay(fn, ms) {
    let timer;
    return function(...args) {
      clearTimeout(timer)
      timer = window.setTimeout(fn.bind(this, ...args), ms || 0)
    }
  },

  // pengecekan keseluruhan untuk submit pengecekan pembayarn
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
  // membersihkan hasil pencarian ketika pencarian pada produk pembelian
  hideResult() {
    let listResults = document.querySelectorAll(".listSearch");

    listResults.forEach(result => {
      result.innerHTML = "";
    });
  },

  //penncaraian data 
  initSearchProduct() {
    //keyup = untuk memerintahkan satu fungsi dan dibungkus oleh fungsio delay untuk mejeda ke carian server
    document.querySelector("#inputKodeProduk").addEventListener("keyup", Penjualan.delay(function() {
      Penjualan.searchProduct();
      //0.5 detik
    }, 1000));
    // blur selesi tulis
    document.querySelector("#inputKodeProduk").addEventListener("blur", Penjualan.delay(function() {
      Penjualan.hideResult();
    }, 500));
  },

  //untuk recues produk  server
  async searchProduct() {
    Penjualan.listSearchProduct = [];
    let kodeProduk = document.querySelector("#inputKodeProduk").value;
    
    let request = await fetch(`${Penjualan.baseUrl}/penjualan/produk/search?kode=${kodeProduk}`);
    //ketika aman ma disimpan
    if (request.ok) {
      let response = await request.json();
      if (response.status) {
        Penjualan.listSearchProduct = response.data;
      }
      Penjualan.renderSearchProduct();
    }
  },

  //untuk akes div kosong menggambar hasil data ynag diterim dari server
  renderSearchProduct() {
    let template = document.querySelector("#templateSearchProduk");

    let html = "";
    // jika data nay ada maka akan di temukan dan ditampilkan
    if (Penjualan.listSearchProduct.length > 0) {
      Penjualan.listSearchProduct.forEach(item => {
        //ketika data di pilih makan akan di munculkan choicedProduct
        html += `<p onclick="Penjualan.choicedProduct('${item.id_produk}')">${item.kode_produk} - ${item.nama_produk} - ${item.tgl_exp}</p>`;
      });
    } else {
      //jika tidak maka akn muncul seperti ini
      html += `<p>Produk tidak ditemukan!</p>`;
    }
    //di reander html
    template.innerHTML = html;
  },
// numberin doang 
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
//untuk mengubah value number format menghapus mengubah
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
  //membayar coma kaan dihapus, dan supay abisa dibitung supay di anggap string bukan integer
  deleteComma(value) {
    return value.toString().replace(/,/g, "");
  },
  //untuk menemukan prodak untuk mengambil berdasarkan id nya
  choicedProduct(idProduk) {
    let findProduk = Penjualan.listSearchProduct.find(item => item.id_produk == idProduk);
    
    if (findProduk) {
      //ketika ketemu amakan akan di tampilkan untuk render
      Penjualan.choiceProduk = findProduk;
      Penjualan.renderChoiceProduk();
    }
  },

  //untuk eksekusi roduk yanag telah di pilih lalu digambarkan ke table]
  renderChoiceProduk() {
    let html = Penjualan.templateRowProduk(Penjualan.choiceProduk);
    //untuk insert tempal ke kuery
    document.querySelector("#templateListProduk").insertAdjacentHTML("beforeend", html);
     //untuk format rupiaah
    Penjualan.bindNumberFormat();
   
    Penjualan.reIndexRow();
    Penjualan.calculateAll();
  },
  //untuk menmpilkan tek html tamble dan mengiri variable data 
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
  // untuk menginput data perhuitungan
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
  //untuk perhitungan keseluruhan
  calculateAll() {
    Penjualan.calculate();
    // untuk menghapus koma supaya terbaca integer
    let inputBayar = parseInt(Penjualan.deleteComma(document.querySelector("#inputBayar").value));
    Penjualan.totalPayment = inputBayar;
    document.querySelector("#inputDiterima").value = isNaN(inputBayar) ? 0 : Penjualan.numberFormat(inputBayar);
    //untuk kaalkulasikan input bayar dan dikembalikan
    let kembalian = inputBayar - Penjualan.totalOrder;
    document.querySelector("#inputKembalian").value = isNaN(kembalian) ? 0 : Penjualan.numberFormat(kembalian);
  },
//untuk mengubah nonber number 1. 2.
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
  // delet row untuk mendelet yanag udah disiap kan
  deleteRow(index) {
    let row = document.querySelector("#row-" + index);
    row.remove();
    Penjualan.reIndexRow();
  }
};


//untuk memngil keseluruhan dan menjalan kan 
Penjualan.initSearchProduct();
//mengaplikasi nak nomber format 
Penjualan.bindNumberFormat();