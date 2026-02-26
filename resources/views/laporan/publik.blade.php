@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-md">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Portal /</span> Aduan Masyarakat Terbuka
            </h4>
            <p class="mb-4">Menampilkan data transparan dengan detail tanggapan petugas secara real-time.</p>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Daftar Laporan Terkini</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Laporan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body-api" class="table-border-bottom-0">
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mb-0" id="pagination-links">
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan & Tanggapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-content-detail">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = new bootstrap.Modal(document.getElementById('modalDetail'));
        const modalContent = document.getElementById('modal-content-detail');

        function fetchLaporan(page = 1) {
            const tableBody = document.getElementById('table-body-api');
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            fetch(`/api/laporan-publik?page=${page}`)
                .then(response => response.json())
                .then(result => {
                    renderTable(result.data, result.meta.from);
                    renderPagination(result.meta, result.links);
                });
        }

        function renderTable(data, startNumber) {
            const tableBody = document.getElementById('table-body-api');
            tableBody.innerHTML = '';

            data.forEach((item, index) => {
                let badgeClass = item.status === 'Selesai' ? 'bg-label-success' :
                                 (item.status === 'Diproses' ? 'bg-label-warning' :
                                 (item.status === 'Ditolak' ? 'bg-label-danger' : 'bg-label-primary'));

                const row = `
                    <tr>
                        <td>${startNumber + index}</td>
                        <td><strong>${item.judul_laporan}</strong></td>
                        <td><span class="text-info"><i class="bx bx-tag-alt me-1"></i>${item.kategori}</span></td>
                        <td>${item.tanggal}</td>
                        <td><span class="badge ${badgeClass}">${item.status}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-detail" data-id="${item.id}">
                                <i class="bx bx-show me-1"></i> Detail
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });

            document.querySelectorAll('.btn-detail').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    showDetail(id);
                });
            });
        }

        function showDetail(id) {
            modalEl.show();
            modalContent.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';

            fetch(`/api/laporan/${id}`)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;

                    // Render Tanggapan
                    let tanggapanHtml = '';
                    if(data.daftar_tanggapan.length > 0) {
                        data.daftar_tanggapan.forEach(t => {
                            tanggapanHtml += `
                                <div class="card bg-label-secondary mb-3">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="fw-bold"><i class="bx bx-user-voice me-1"></i>${t.petugas} (Petugas)</span>
                                            <small class="text-muted">${t.tgl_tanggapan}</small>
                                        </div>
                                        <p class="mb-0 text-dark">${t.isi_tanggapan}</p>
                                    </div>
                                </div>`;
                        });
                    } else {
                        tanggapanHtml = '<div class="alert alert-secondary text-center">Belum ada tanggapan dari petugas.</div>';
                    }

                    modalContent.innerHTML = `
                        <div class="row">
                            <div class="col-md-7 border-end">
                                <h6 class="text-muted text-uppercase small">Isi Laporan</h6>
                                <p class="fw-bold text-dark" style="font-size: 1.1rem;">${data.isi_laporan}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="d-block text-muted">Pelapor</small>
                                        <p class="fw-semibold">${data.pelapor.nama}</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="d-block text-muted">Kategori</small>
                                        <p class="fw-semibold"><span class="badge bg-label-info">${data.kategori}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h6 class="text-muted text-uppercase small">Tanggapan Petugas</h6>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    ${tanggapanHtml}
                                </div>
                            </div>
                        </div>
                    `;
                });
        }

        function renderPagination(meta, links) {
            const paginationLinks = document.getElementById('pagination-links');
            paginationLinks.innerHTML = '';

            meta.links.forEach(link => {
                const activeClass = link.active ? 'active' : '';
                const disabledClass = !link.url ? 'disabled' : '';

                // Bersihkan label (untuk Previous/Next)
                let label = link.label.replace('&laquo; ', '').replace(' &raquo;', '');
                if(label === 'Previous') label = '<i class="bx bx-chevron-left"></i>';
                if(label === 'Next') label = '<i class="bx bx-chevron-right"></i>';

                const li = `
                    <li class="page-item ${activeClass} ${disabledClass}">
                        <a class="page-link" href="javascript:void(0);" data-url="${link.url}">${label}</a>
                    </li>`;
                paginationLinks.innerHTML += li;
            });

            document.querySelectorAll('.page-link').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    if(url) {
                        const page = new URL(url).searchParams.get('page');
                        fetchLaporan(page);
                    }
                });
            });
        }

        fetchLaporan(1);
    });
</script>
@endpush
