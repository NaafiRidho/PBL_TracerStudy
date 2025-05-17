<form id="form-edit-alumni" method="POST" action="{{ url('/admin/alumni/update/' . $alumni->alumni_id) }}">
    @csrf
    @method('PUT')
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Alumni</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Program Studi</label>
                    <select name="prodi" class="form-control" required>
                        <option value="D-IV TI" {{ $alumni->prodi == 'D-IV TI' ? 'selected' : '' }}>D-IV TI</option>
                        <option value="D-IV SIB" {{ $alumni->prodi == 'D-IV SIB' ? 'selected' : '' }}>D-IV SIB</option>
                    </select>
                    <small id="error-prodi" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>NIM</label>
                    <input type="text" name="nim" value="{{ $alumni->nim }}" class="form-control" required>
                    <small id="error-nim" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Nama Alumni</label>
                    <input type="text" name="nama_alumni" value="{{ $alumni->nama_alumni }}" class="form-control" required>
                    <small id="error-nama_alumni" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label>Tanggal Lulus</label>
                    <input type="date" name="tanggal_lulus" value="{{ $alumni->tanggal_lulus->format('Y-m-d') }}" class="form-control" required>
                    <small id="error-tanggal_lulus" class="error-text text-danger"></small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
$(function() {
    // Close modal
        $('#myModal .close, #myModal .btn-warning').on('click', function () {
            $('#myModal').modal('hide');
        });

    $('#form-edit-alumni').validate({
        rules: {
            prodi: { required: true },
            nim: { required: true, minlength: 5 },
            nama_alumni: { required: true, minlength: 3 },
            tanggal_lulus: { required: true, date: true }
        },
        submitHandler: function(form) {
            $.ajax({
                url: $(form).attr('action'),
                method: 'PUT',
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire('Berhasil', response.message, 'success');
                        dataUser.ajax.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
            return false;
        }
    });
});
</script>