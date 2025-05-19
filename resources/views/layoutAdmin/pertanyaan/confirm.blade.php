@extends('layoutAdmin.app')
@section('content')

<form action="{{ url('/admin/pertanyaan/' . $pertanyaan->getKey() . '/delete_ajax') }}" method="POST" id="form-delete">
    @csrf
    @method('DELETE')
    <div id="modalDelete" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Pertanyaan</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="closeModalDelete()"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda yakin ingin menghapus data pertanyaan berikut?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Pertanyaan :</th>
                            <td class="col-9">{{ $pertanyaan->pertanyaan }}</td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" onclick="closeModalDelete()">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function closeModalDelete() {
    $('#modalDelete').modal('hide');
    setTimeout(function () {
      $('#modalDelete').remove(); // hapus dari DOM
      $('.modal-backdrop').remove();
    }, 300);
  }
$(document).ready(function() {
    // VALIDASI & SUBMIT AJAX
    $("#form-delete").validate({
        rules: {},
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status){
                        closeModalDelete();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        window.tablePertanyaan.ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menghapus data.'
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
@endsection
