@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Import Data Barang</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('/barang/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data"> 
            @csrf 
            <div class="form-group">
                <label>Download Template</label>
                <div>
                    <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download Template Excel
                    </a>
                </div>
                <small class="form-text text-muted">Gunakan template ini untuk mengimport data barang</small>
            </div>
            
            <div class="form-group">
                <label for="file_barang">Pilih File Excel</label>
                <input type="file" name="file_barang" id="file_barang" class="form-control" required accept=".xlsx">
                <small id="error-file_barang" class="error-text form-text text-danger"></small>
            </div>
            
            <div class="form-group text-right">
                <button type="button" onclick="window.history.back()" class="btn btn-warning mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
<style>
    .error-text {
        color: #dc3545;
        font-size: 0.875em;
    }
    .is-invalid {
        border-color: #dc3545;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_barang: {
                    required: true,
                    extension: "xlsx"
                }
            },
            messages: {
                file_barang: {
                    required: "File Excel wajib diupload",
                    extension: "Hanya file Excel (.xlsx) yang diperbolehkan"
                }
            },
            submitHandler: function(form) {  
                var formData = new FormData(form);
                $('.btn-primary').html('<i class="fas fa-spinner fa-spin"></i> Memproses...').attr('disabled', true);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.btn-primary').html('<i class="fas fa-upload"></i> Upload').attr('disabled', false);
                        
                        if(response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ url('barang') }}";
                            });
                        } else {
                            $('.error-text').text('');
                            if(response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-'+prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Terjadi kesalahan saat mengimport data'
                            });
                        }
                    },
                    error: function(xhr) {
                        $('.btn-primary').html('<i class="fas fa-upload"></i> Upload').attr('disabled', false);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
