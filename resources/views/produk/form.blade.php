<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form action="" method="post" class="form-horizontal">
  <!-- @csrf = adalah token -->
      @csrf
    @method('post')

      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="nama_produk" class="col-md-2 col-md-offset-1 control-lable" autofocus >Nama</label>
            <div class="col-md-9">
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" required autofocus>
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="id_kategori" class="col-md-2 col-md-offset-1 control-lable">Kategoti</label>
            <div class="col-md-9">
                <select name="id_kategori" id="id_kategori" class="form-control" required>
                  <option value="">Pilih Kategori</option>
                  @foreach ($kategori as $key => $item)
                  <option value="{{ $key }}">{{ $item }}</option>
                  @endforeach
                </select>
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="merk" class="col-md-2 col-md-offset-1 control-lable">Merek</label>
            <div class="col-md-9">
                <input type="text" name="merk" id="merk" class="form-control">
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="harga_beli" class="col-md-2 col-md-offset-1 control-lable">Harga Beli</label>
            <div class="col-md-9">
                <input type="number" name="harga_beli" id="harga_beli" class="form-control">
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="harga_jual" class="col-md-2 col-md-offset-1 control-lable">Harga Jual</label>
            <div class="col-md-9">
                <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="stok" class="col-md-2 col-md-offset-1 control-lable">Stok</label>
            <div class="col-md-9">
                <input type="number" name="stok" id="stok" class="form-control" required value="0">
                <span class="help-block with-errors"></span>
            </div>
        </div>

        <div class="form-group row">
             <!-- memanggil data base  -->
            <label for="tgl_exp" class="col-md-2 col-md-offset-1 control-lable">TGL Expe</label>
            <div class="col-md-9">
                <input type="date" name="tgl_exp" id="tgl_exp" class="form-control">
                <span class="help-block with-errors"></span>
            </div>
        </div>

        
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
      </div>
    </div>
  </form>
  </div>
</div>