@extends('layoutAdmin.app')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Rekap Pengguna Lulusan Sudah Mengisi Survey</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard / Pengguna Sudah Mengisi</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fs-5"><i class="fas fa-building me-2"></i> Daftar Pengguna </span>
                <a href="{{ url('/admin/atasan/export/excel/sudah') }}" class="btn btn-success px-4 py-2 fs-6">
                    <i class="fas fa-file-export me-2"></i> Export
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="table_pengguna_sudah">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Nama Atasan</th>
                                <th>Instansi</th>
                                <th>Jabatan</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>Nama Alumni</th>
                                <th>Program Studi</th>
                                <th>Tahun Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($atasan as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $item->nama_atasan ?? '-' }}</td>
                                    <td>{{ $item->nama_instansi ?? '-' }}</td>
                                    <td>{{ $item->jabatan ?? '-' }}</td>
                                    <td>{{ $item->no_hp_atasan ?? '-' }}</td>
                                    <td>{{ $item->email_atasan ?? '-' }}</td>
                                    {{-- PERBAIKAN DI SINI: Gunakan ->first() untuk mendapatkan objek Alumni --}}
                                    <td>{{ $item->alumni->first()->nama_alumni ?? '-' }}</td>
                                    <td>{{ $item->alumni->first()->prodi ?? '-' }}</td>
                                    <td>
                                        {{-- PERBAIKAN DI SINI: Pastikan Anda mengakses alumni->first() sebelum tanggal_lulus --}}
                                        {{ optional(optional($item->alumni->first())->tanggal_lulus)->format('Y') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data pengguna lulusan yang sudah mengisi.</td>
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

        #table_pengguna_sudah th {
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
            $('#table_pengguna_sudah').DataTable({
                responsive: true,
                autoWidth: false,
            });
        });
    </script>
@endpush