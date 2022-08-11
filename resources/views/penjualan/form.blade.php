<input type="text" class="form-control" name="kode_produk" id="inputKodeProduk" placeholder="Cari kode produk">
<div class="listSearch" id="templateSearchProduk"></div>

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
      <tbody id="templateListProduk"></tbody>
      <tbody>
        <tr>
          <td colspan="5">Total Harga</td>
          <td colspan="2">
            <input type="text" class="form-control" readonly id="inputTotalHarga">
          </td>
        </tr>
        <tr>
          <td colspan="5">Bayar</td>
          <td colspan="2">
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