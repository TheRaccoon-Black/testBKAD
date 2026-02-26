@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Rekap Bulanan BKAD
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tabel Rekapitulasi Laporan</h5>
            <small class="text-muted float-end">Data Agregasi SQL View</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Periode (Bulan & Tahun)</th>
                        <th class="text-center">Total Masuk</th>
                        <th class="text-center">Diproses</th>
                        <th class="text-center">Selesai</th>
                        <th class="text-center">Ditolak</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($rekapBulanan as $rekap)
                    <tr>
                        <td>
                            <i class="bx bx-calendar me-2 text-primary"></i>
                            <span class="fw-bold">
                                {{ DateTime::createFromFormat('!m', $rekap->bulan)->format('F') }} {{ $rekap->tahun }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-label-primary fs-6">{{ $rekap->total_masuk }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-semibold text-warning">{{ $rekap->jumlah_diproses }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-semibold text-success">{{ $rekap->jumlah_selesai }}</span>
                        </td>
                        <td class="text-center">
                            <span class="fw-semibold text-danger">{{ $rekap->jumlah_ditolak }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data laporan untuk direkap.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer text-muted small">
            * Data diperbarui otomatis berdasarkan status laporan terakhir di sistem.
        </div>
    </div>
</div>
@endsection
