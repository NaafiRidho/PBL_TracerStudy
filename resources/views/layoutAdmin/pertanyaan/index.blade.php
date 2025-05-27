@extends('layoutAdmin.app')

@section('title', 'Data Pertanyaan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Pertanyaan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard / Pertanyaan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i> Tabel Pertanyaan</span>
            <button class="btn btn-success btn-sm" onclick="createPertanyaan()"><i class="fas fa-plus-circle me-1"></i>Tambah Pertanyaan</button>
        </div>
        <div class="card-body">
            <table id="tablePertanyaan" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal akan dimuat lewat AJAX -->
<div id="modalContainer"></div>
@endsection

@push('css')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .card-header {
        background-color: #f4f6f9;
    }
    .card-title {
        font-size: 1.5rem;
    }
    .btn {
        transition: all 0.3s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    table.dataTable thead th {
        border-top: 2px solid #dee2e6;
    }
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter {
        margin-bottom: 20px;
    }
    table.dataTable {
        margin-top: 10px;
    }
</style>
@endpush

@section('scripts')
<script>
$(document).ready(function () {
    window.dataPertanyaan = $('#tablePertanyaan').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: '{{ url("/admin/pertanyaan/list") }}',
            error: function(xhr, error, thrown) {
                console.error('Ajax error:', xhr.responseText);
                alert('Terjadi error saat memuat data. Periksa console untuk detail.');
            }
        },
        columns: [
            { data: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },
            { data: 'pertanyaan', name: 'pertanyaan' },
            { data: 'aksi', className: "text-center", orderable: false, searchable: false }
        ]
    });
});

function createPertanyaan() {
    $.get("{{ url('/admin/pertanyaan/create_ajax') }}", function (data) {
        $('#modalContainer').html(data);
        $('#modalCreate').modal('show');
    });
}

function modalEdit(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (html) {
            $('#modalEdit').remove();
            $('body').append(html);
            $('#modalEdit').modal('show');
        },
        error: function () {
            Swal.fire('Gagal', 'Tidak dapat memuat data form edit.', 'error');
        }
    });
}

function modalDelete(url) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (html) {
            $('#modalDelete').remove();
            $('body').append(html);
            $('#modalDelete').modal('show');
        },
        error: function () {
            Swal.fire('Gagal', 'Tidak dapat memuat konfirmasi hapus.', 'error');
        }
    });
}

// ✅ Tambahkan fungsi ini
function deletePertanyaan(id) {
    $.ajax({
        url: '/admin/pertanyaan/' + id + '/delete_ajax',
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            $('#modalDelete').modal('hide');
            $('#tablePertanyaan').DataTable().ajax.reload();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message
            });
        },
        error: function (xhr) {
            Swal.fire('Gagal', 'Data gagal dihapus.', 'error');
        }
    });
}
</script>
@endsection
