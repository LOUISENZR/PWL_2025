@extends('layouts.app')
 
 {{-- Customize layout sections --}}
 
 @section('subtitle', 'Kategori')
 @section('content_header_title', 'Home')
 @section('content_header_subtitle', 'Kategori')
 
 @section('content')
     <div class="container">
         <div class="card">
             <div class="card-header">Manage Kategori</div>            
             <div class="card-body" >
                 {{ $dataTable->table() }}
             </div>
             <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm mb-4">
                <i class="fas fa-plus"></i> Add Kategori
             </a>
         </div>
     </div>
 @endsection
 
 @push('scripts')
     {{ $dataTable->scripts() }}
 @endpush