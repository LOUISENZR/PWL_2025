@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data stok yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Stok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data stok berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-4">Nama Barang:</th>
                            <td class="col-8">{{ $stok->barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">User:</th>
                            <td class="col-8">{{ $stok->user->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Tanggal Stok:</th>
                            <td class="col-8">{{ date('d-m-Y', strtotime($stok->stok_tanggal)) }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Jumlah Stok:</th>
                            <td class="col-8">{{ $stok->stok_jumlah }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-4">Terakhir Diupdate:</th>
                            <td class="col-8">{{ $stok->updated_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        beforeSend: function() {
                            $('.btn-danger').html('<i class="fas fa-spinner fa-spin"></i> Menghapus...').attr('disabled', true);
                        },
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    $('#table-stok').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                                $('.btn-danger').html('Ya, Hapus').attr('disabled', false);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan pada server'
                            });
                            $('.btn-danger').html('Ya, Hapus').attr('disabled', false);
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty