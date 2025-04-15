@extends('layouts.template')
 
 @section('content')
     <div class="card card-outline card-primary">
         <div class="card-header">
             <h3 class="card-title">{{ $page->title }}</h3>
             <div class="card-tools"> 
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>        </div> 
              </div> 
         </div>
         <div class="card-body">
             @if (session('success'))
                 <div class="alert alert-success">{{ session('success') }}</div>
             @endif
 
             @if (session('error'))
                 <div class="alert alert-danger">{{ session('error') }}</div>
             @endif
             <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>Kode</th>
                         <th>Nama</th>
                         <th>Alamat</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
             </table>
         </div>
     </div>
 @endsection
 <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 

 @push('css')
 @endpush
 
 @push('js')
     <script>
         $(document).ready(function() {
             var dataSupplier = $('#table_supplier').DataTable({
                 serverSide: true,
                 ajax: {
                     "url": "{{ url('supplier/list') }}",
                     "dataType": "json",
                     "type": "POST"
                 },
                 columns: [{
                     // nomor urut dari laravel datatable addIndexColumn() 
                     data: "DT_RowIndex",
                     className: "text-center",
                     orderable: false,
                     searchable: false
                 }, {
                     data: "supplier_kode",
                     className: "",
                     orderable: true,
                     searchable: true
                 }, {
                     data: "supplier_nama",
                     className: "",
                     orderable: false,
                     searchable: false
                 }, {
                     data: "supplier_alamat",
                     className: "",
                     orderable: false,
                     searchable: false
                 }, {
                     data: "aksi",
                     className: "",
                     orderable: false,
                     searchable: false
                 }]
             });
 
         });
     </script>
 @endpush