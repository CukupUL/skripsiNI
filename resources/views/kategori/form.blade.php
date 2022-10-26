<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <!-- untuk memebuat form horizontal -->
  <form action="" method="post" class="form-horizontal">
  <!-- @csrf = adalah token supaya tidak kadaluaras-->
      @csrf
      <!-- suapa bisa melakukan edit maka ditambahkan methode post -->
    @method('post')

      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <!-- membuat form grup -->
        <div class="form-group row">
            <!-- memanggil data base -->
            <label for="nama_kategori" class="col-md-2 col-md-offset-1 control-lable">Kategori</label>
            <!-- untuk memasukan kedata yanag telah di tambahkan -->
            <div class="col-md-9">
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required autofocus>
                <!-- untuk menambahkan jika ada error -->
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