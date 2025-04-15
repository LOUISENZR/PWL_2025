@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Barang</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}'" class="btn btn-info">
                    <i class="fas fa-file-import"></i> Import Barang
                </button>
                <a href="{{ url('/barang/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-
                    excel"></i> Export Barang</a>
                <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file
                    pdf"></i> Export Barang</a>  
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Tambah Data (Ajax)
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter data -->
            <div id="filter" class="form-horizontal filter-data p-2 border-bottom mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row mb-0">
                            <label for="filter_kategori" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                    <option value="">- Semua Kategori -</option>
                                    @foreach($kategori as $l)
                                        <option value="{{ $l->kategori_id }}">{{ $l->kategori_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table-barang" style="width:100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th width="12%">Harga Beli</th>
                            <th width="12%">Harga Jual</th>
                            <th width="15%">Kategori</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal content akan di-load via AJAX -->
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .table th {
            white-space: nowrap;
        }
    </style>
@endpush

@push('js')
<script>
    function modalAction(url = ''){
        $('#myModal').modal('show').find('.modal-content').load(url);
    }

    $(document).ready(function(){
        var tableBarang = $('#table-barang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('barang/list') }}",
                type: "POST",
                data: function (d) {
                    d.filter_kategori = $('.filter_kategori').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { 
                    data: "DT_RowIndex", 
                    name: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false 
                },
                { 
                    data: "barang_kode", 
                    name: "barang_kode",
                    className: "text-nowrap"
                },
                { 
                    data: "barang_nama", 
                    name: "barang_nama"
                },
                { 
                    data: "harga_beli", 
                    name: "harga_beli",
                    className: "text-right",
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                { 
                    data: "harga_jual", 
                    name: "harga_jual",
                    className: "text-right",
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
                { 
                    data: "kategori.kategori_nama", 
                    name: "kategori.kategori_nama"
                },
                { 
                    data: "aksi", 
                    className: "text-center text-nowrap",
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return data;
                    }
                }
            ],
            order: [[1, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });

        // Live search dengan delay
        var searchTimer;
        $('#table-barang_filter input').unbind().bind('keyup', function(e) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                tableBarang.search($('#table-barang_filter input').val()).draw();
            }, 500);
        });

        $('.filter_kategori').change(function() {
            tableBarang.draw();
        });

        // Refresh tabel setiap 30 detik
        setInterval(function() {
            tableBarang.ajax.reload(null, false);
        }, 30000);
    });
</script>
@endpush