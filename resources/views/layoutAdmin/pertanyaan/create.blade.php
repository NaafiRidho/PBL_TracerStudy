<div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formCreatePertanyaan">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Tambah Pertanyaan</h5>
            <button type="button" class="btn-close" aria-label="Close" onclick="closeModalCreate()"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                <input type="text" class="form-control" id="pertanyaan" name="pertanyaan" placeholder="Masukkan pertanyaan" required>
                <small id="errorPertanyaan" class="text-danger"></small>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModalCreate()">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function closeModalCreate() {
    $('#modalCreate').modal('hide');
    setTimeout(function () {
      $('#modalCreate').remove();
      $('.modal-backdrop').remove();
    }, 300);
  }

  $(function () {
    $('#formCreatePertanyaan').on('submit', function (e) {
      e.preventDefault();

      $('#errorPertanyaan').text('');
      $('#pertanyaan').removeClass('is-invalid');

      $.ajax({
        url: "{{ url('/admin/pertanyaan/store') }}",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
          if (response.status) {
            closeModalCreate();
            Swal.fire('Sukses', response.message, 'success');
            $('#tablePertanyaan').DataTable().ajax.reload(null, false);
          } else {
            Swal.fire('Gagal', response.message, 'error');
            if (response.msgField && response.msgField.pertanyaan) {
              $('#errorPertanyaan').text(response.msgField.pertanyaan[0]);
              $('#pertanyaan').addClass('is-invalid');
            }
          }
        },
        error: function () {
          Swal.fire('Error', 'Terjadi kesalahan saat menyimpan data.', 'error');
        }
      });
    });
  });
</script>
