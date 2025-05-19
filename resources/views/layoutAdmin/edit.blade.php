<form action="{{ url('/admin/profesi/' . $profesi->profesi_id . '/update_ajax') }}" method="POST" id="form-tambah">
    @csrf
    @method('PUT')
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Profesi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bi bi-x"></i></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Kategori Profesi</label>
                    <select name="kategori_profesi_id" id="kategori_profesi_id" class="form-control" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori_profesi as $kategori)
                            <option value="{{ $kategori->kategori_profesi_id }}" {{$kategori->kategori_profesi_id==$profesi->kategori_profesi_id ? 'selected' : '' }}>
                                {{ $kategori->kategori_profesi }}</option>
                        @endforeach
                    </select>
                    <small id="error-kategori_profesi_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Profesi</label>
                    <input type="text" name="profesi" id="profesi" class="form-control" value="{{$profesi->profesi}}" required>
                    <small id="error-profesi" class="error-text form-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        // Menambahkan event handler untuk tombol close dan batal
        $('#myModal .close, #myModal .btn-warning').on('click', function () {
            $('#myModal').modal('hide');
        });
        // Menambahkan validasi form dengan jQuery Validator
        $("#form-tambah").validate({
            rules: {
                kategori_profesi_id: {
                    required: true,
                    number: true
                },
                profesi: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                }
            },
            submitHandler: function (form) {
                // AJAX untuk mengirim data form ke server
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUser.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>