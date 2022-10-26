@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Daftar Produk
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"> Daftar Produk</li>
@endsection

@section('content')
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-border">
                <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"> <i class="fa fa-plus-circle"></i> Tambah </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="10%">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Harga Beli</th>
                        <th>Harga jual</th>
                        <th>Stok</th>
                        <th>Tgl Exp</th> 
                        <th>Last Update</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- untuk memanggil form.blade.php -->
@includeIf('produk.form')
@endsection

@push('scripts')
<script>
    let table;
    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('produk.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                // {data: 'select_all'},
                {data: 'kode_produk', sortable: false},
                {data: 'nama_produk', sortable: false},
                {data: 'nama_kategori', sortable: false},
                {data: 'merk', sortable: false},
                {data: 'harga_beli', sortable: false},
                {data: 'harga_jual', sortable: false},
                {data: 'stok', sortable: false},
                {data: 'tgl_exp', sortable: false},
                {data: 'updated_at', sortable: false},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });
        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });
    });
    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Produk');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama_produk]').focus();
    }
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Produk');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_produk]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_produk]').val(response.nama_produk);
                $('#modal-form [name=id_kategori]').val(response.id_kategori);
                $('#modal-form [name=merk]').val(response.merk);
                $('#modal-form [name=harga_beli]').val(response.harga_beli);
                $('#modal-form [name=harga_jual]').val(response.harga_jual);
                $('#modal-form [name=stok]').val(response.stok);
                $('#modal-form [name=tgl_exp]').val(response.tgl_exp);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush