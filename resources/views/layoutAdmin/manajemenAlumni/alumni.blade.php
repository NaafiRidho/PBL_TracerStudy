@extends('layoutAdmin.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Alumni</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard / Alumni</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-graduate me-1"></i> Tabel Alumni</span>
            <div class="d-flex gap-2">
                <button type="button" onclick="modalAction('{{ url('admin/alumni/import_ajax') }}')" class="btn btn-primary btn-sm">
                    <i class="fas fa-file-import me-1"></i> Import Data Alumni
                </button>
                <a href="{{ url('/profesi/export_excel') }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-file-excel me-1"></i> Export Data Alumni
                </a>
                <button onclick="modalAction('{{ url('admin/alumni/create_ajax') }}')" 
                        class="btn btn-success btn-sm" 
                        title="Tambah alumni baru">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Alumni
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <p><strong>Daftar alumni</strong></p>
            <p>Berikut adalah daftar alumni yang tersedia. Anda dapat mengimpor, mengekspor, dan menambah alumni baru menggunakan tombol di atas.</p>

            <table class="table table-bordered table-striped" id="table_user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Program Studi</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tanggal Lulus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

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

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
            // Inisialisasi modal Bootstrap setelah konten dimuat
            $('#myModal').modal({
                backdrop: 'static', // Jika Anda ingin backdrop statis
                keyboard: false     // Jika Anda ingin menonaktifkan tombol Escape
            });
        });
    }

    $(document).ready(function () {
        window.dataUser = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ url('admin/alumni/listalumni') }}",
                type: "POST",
                data: function (e) {
                    e._token = '{{ csrf_token() }}';
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "prodi", name: "prodi" },
                { data: "nim", name: "nim" },
                { data: "nama_alumni", name: "nama_alumni" },
                { data: "tanggal_lulus", name: "tanggal_lulus" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });
    });
</script>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endpush