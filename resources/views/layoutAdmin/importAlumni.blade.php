<meta name="csrf-token" content="{{ csrf_token() }}">
<form action="{{ url('/admin/alumni/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Alumni</h5>
                <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_alumni.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_user" id="file_user" class="form-control" required>
                    <small id="error-file_user" class="text-danger form-text"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" id="btn-submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>


<script>
$(document).ready(function() {
    // Setup CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    $('#form-import').on('submit', function(e) {
        e.preventDefault(); // cegah submit default

        let form = this;
        let formData = new FormData(form);

        // Validasi ekstensi manual
        let fileInput = $('#file_user').val();
        if (!fileInput || !fileInput.endsWith('.xlsx')) {
            $('#error-file_user').text('File harus berformat .xlsx');
            return;
        } else {
            $('#error-file_user').text('');
        }

        $.ajax({
            url: $(form).attr('action'), // sudah benar: /admin/alumni/import_ajax
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status) {
                    $('#form-import').closest('.modal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        html: response.message + (response.skipped?.length
                            ? '<br><br><strong>Catatan:</strong><br>' + response.skipped.join('<br>')
                            : '')
                    });
                    dataUser.ajax.reload();
                } else {
                    $('#error-file_user').text('');
                    if (response.msgField) {
                        $.each(response.msgField, function(key, value) {
                            $('#error-' + key).text(value[0]);
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat mengirim data.'
                });
                console.log(xhr.responseText);
            }
        });
    });
});
</script>


