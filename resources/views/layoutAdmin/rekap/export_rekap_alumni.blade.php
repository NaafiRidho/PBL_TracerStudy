@extends('layoutAdmin.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Alumni Sudah Mengisi Tracer Study</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard / Alumni Sudah Mengisi</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fs-5"><i class="fas fa-users me-2"></i> Daftar Alumni Sudah Mengisi TS</span>
                <a href="{{ url('/admin/rekap/export/alumni-sudah') }}" class="btn btn-success px-4 py-2 fs-6">
                    <i class="fas fa-file-export me-2"></i> Export
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="table_alumni_sudah">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Program Studi</th>
                                <th>NIM</th>
                                <th>Nama Alumni</th>
                                <th>Tanggal Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alumni as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $item->prodi }}</td>
                                    <td>{{ $item->nim }}</td>
                                    <td>{{ $item->nama_alumni }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data alumni yang sudah mengisi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .table th,
        .table td {
            vertical-align: middle;
        }

        .card-header {
            background-color: #f4f6f9;
        }

        #table_alumni_sudah th {
            text-align: center;
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
        $(document).ready(function () {
            $('#table_alumni_sudah').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });
    </script>
@endpush
