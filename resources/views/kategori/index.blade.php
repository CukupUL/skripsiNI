@extends('layouts.master') 
<!--extends untuk memanggil dari folder layouts.master -->
@section('title')
    Daftar Kategori
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header with-border">
                <!-- menmbahkan buton untuk penambahan kategori // ketika modal di clik akan masuk dan membuka form // btn-flat = untuk menghilangkan rounded/cekungan pada buton -->
                <button onclick="addForm('{{ route('kategori.store') }}')" class="btn btn-success btn-xs btn-flat"> <i class="fa fa-plus-circle"></i> Tambah </button>
              </div>
              <!-- /table responsif untuk mengikuti alur pada tampilar // table stripd  -->
              <div class="card-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

<!-- untuk memanggil form.blade.php untuk include-->
@includeIf('kategori.form')
@endsection

<!-- untuk membuat data table supaya dapat di munculkan dari master membuat script seperti dibawah maka akan muncul datatable-->
@push('scripts')
<script>
    let table;
    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            // menambahkan ajax untuk mengarahkan ujntuk pemangilan data
            ajax: {
                url: '{{ route('kategori.data') }}',
            },
            // untuk menampilkan data di tampilan datatables
            columns: [
                //dt_rowsindex sudah ada dari bawaan nya tinggal di gunakan alalu dibuatkan fungsi supaya tidak bisa di cari dan di sorting atau di ubah [ada tampilan bawaan nya]
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'nama_kategori'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        // melaukan validator teerhadap inputan 
        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        //carikan modal-form dan jika berhadil maka hide lalau data realod supaya sinkrom
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
        // untuk menampilkan modal-form
        $('#modal-form').modal('show');
        // untuk menganti title pada form
        $('#modal-form .modal-title').text('Tambah Kategori');
        //melakukan reset dan memberikan 0 untuk memastikan
        $('#modal-form form')[0].reset();
        //untuk memasing url yang telah di buat diatas baris 17
        $('#modal-form form').attr('action', url);
        // untuk menganti _metode menjadi post 
        $('#modal-form [name=_method]').val('post');
        // untuk mentriger nama_kategori
        $('#modal-form [name=nama_kategori]').focus();
    }
    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Kategori');
        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        //dibuban menjadi put
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama_kategori]').focus();
        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama_kategori]').val(response.nama_kategori);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }
    function deleteData(url) {
        // menghindari tidak sengaja di apus 
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                //karna mengunakan pous untuk men genret token nya dan di file master.blade
                //_metode = delete 
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