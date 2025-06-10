<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ url('/admin/pertanyaan/' . $data->pertanyaan_id . '/update_ajax') }}" method="POST" id="form-edit">  // <--- Ganti ke $data->id  @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Pertanyaan</h5>
          <button type="button" class="btn-close" aria-label="Close" onclick="closeModalEdit()"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="pertanyaan">Pertanyaan</label>
            <input type="text" name="pertanyaan" id="pertanyaan" class="form-control" value="{{ $data->pertanyaan }}" required>
            <small id="error-pertanyaan" class="error-text form-text text-danger"></small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="closeModalEdit()">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function closeModalEdit() {
    $('#modalEdit').modal('hide');
    setTimeout(function () {
      $('#modalEdit').remove(); // hapus dari DOM
      $('.modal-backdrop').remove();
    }, 300);
  }

  $(function () {
    $('#form-edit').validate({
      rules: {
        pertanyaan: {
          required: true,
          minlength: 5,
          maxlength: 255
        }
      },
      submitHandler: function (form, event) {
        event.preventDefault();

        $.ajax({
          url: form.action,
          method: $(form).attr('method'),
          data: $(form).serialize(),
          dataType: 'json',
          success: function (response) {
            if (response.status) {
              closeModalEdit();
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message
              });
              $('#tablePertanyaan').DataTable().ajax.reload(null, false);
            } else {
              $('.error-text').text('');
              $.each(response.msgField, function (field, msg) {
                $('#error-' + field).text(msg[0]);
              });
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.message
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: 'error',
              title: 'Kesalahan Server',
              text: 'Gagal memperbarui data. Silakan coba lagi.'
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
      highlight: function (element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element) {
        $(element).removeClass('is-invalid');
      }
    });
  });
  
</script>
