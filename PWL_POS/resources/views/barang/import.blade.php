<form action="{{ url('/barang/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <div class="input-group">
                        <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm" download>
                            <i class="fas fa-file-excel"></i> Download Template
                        </a>
                    </div>
                    <small id="error-template" class="error-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <div class="custom-file">
                        <input type="file" name="file_barang" id="file_barang" class="custom-file-input" required>
                        <label class="custom-file-label" for="file_barang">Pilih file...</label>
                    </div>
                    <small class="form-text text-muted">Format file harus .xlsx</small>
                    <small id="error-file_barang" class="error-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // Tampilkan nama file yang dipilih
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Validasi form
    $("#form-import").validate({
        rules: {
            file_barang: {
                required: true,
                extension: "xlsx|xls"
            }
        },
        messages: {
            file_barang: {
                required: "File wajib diupload",
                extension: "Format file harus Excel (.xlsx atau .xls)"
            }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            
            $.ajax({
                url: form.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                },
                success: function(response) {
                    if(response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 2000
                        });
                        tableBarang.ajax.reload(null, false);
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengupload file'
                    });
                },
                complete: function() {
                    $('.btn-primary').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload');
                }
            });
            return false;
        }
    });
});
</script>