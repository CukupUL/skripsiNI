<input type="text" class="form-control" name="kode_produk" id="inputKodeProduk" placeholder="Cari kode produk"> 
<!-- div kosong untuk menyimpan text div dari semau yang dicari (hasil pencari akan di simpan disan sementara) -->
<div class="listSearch" id="templateSearchProduk"></div>
<!-- untuk mengisi dat data prodkak yang telah di tambahkan // old = untuk mengembalikan nilai ketika submit gagal input tan tidak dihapus // ?? = akan mengambil data ke dua kalau data produk tidak ada (seperti if secara singkat kalau engga ada akan lanjut kepencarian selanjutnya) -->
<input type="hidden" id="inputHiddenDataProduct" name="data_product" value="{{ old('data_product') ?? (isset($data_product) ? json_encode($data_product) : '[]') }}">

<div class="card">
  <div class="card-body table-responsive">
    <table class="table table-bordered w-100">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th></th>
        </tr>
      </thead>
      <!-- tmpalte lis produk setelahnya dicari maka akan disimpan pada id templateproduk dibawah -->
      <tbody id="templateListProduk"></tbody>
      <tbody>
        <tr>
          <!-- untuk memaukan langsung dari ssitem yanagtelah di inputkan // redonly = sistem yanag akan mengisi kedalam tex inputan -->
          <td colspan="5">Total Harga</td>
          <td colspan="2">
            <input type="text" class="form-control" readonly id="inputTotalHarga">
          </td>
        </tr>
        <tr>
          <td colspan="5">Bayar</td>
          <td colspan="2">
            <!-- text yanag dibayar input kan // onblur untuk melakukan satu fungs idi belakang // id= inputbaayr = untk mengambil satu elmen ynag di js-->
            <input type="text" class="form-control number-format" onblur="Penjualan.calculateAll()" name="bayar" id="inputBayar">
          </td>
        </tr>
        <tr>
          <td colspan="5">Diterima</td>
          <td colspan="2">
            <input type="text" class="form-control" name="bayar" id="inputDiterima" readonly>
          </td>
        </tr>
        <tr>
          <td colspan="5">Kembalian</td>
          <td colspan="2">
            <input type="text" class="form-control" name="kembalian" id="inputKembalian" readonly>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

@push('scripts')
  <script src="{{ asset('js/penjualan.js') }}"></script>
@endpush