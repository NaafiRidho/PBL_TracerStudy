@extends('layoutAdmin.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Data Profesi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard / Profesi</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-briefcase me-1"></i> Tabel Profesi</span>
            <button onclick="modalAction('{{ url('admin/profesi/create_ajax') }}')" 
                    class="btn btn-success btn-sm" 
                    title="Tambah Profesi Baru">
                <i class="fas fa-plus-circle me-1"></i> Tambah Profesi
            </button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <p><strong>Daftar Profesi</strong></p>
            <p>Berikut adalah daftar profesi yang tersedia. Anda dapat mengimpor, mengekspor, dan menambah profesi baru menggunakan tombol di atas.</p>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kategori Profesi</th>
                            <th>Profesi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
            ajax: {
                url: "{{ url('admin/profesi/listprofesi') }}",
                type: "POST",
                data: function (e) {
                    e._token = '{{ csrf_token() }}';
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "kategori_profesi", name: "kategori_profesi", searchable:true },
                { data: "profesi", name: "profesi" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ]
        });
    });
</script>

<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endpush