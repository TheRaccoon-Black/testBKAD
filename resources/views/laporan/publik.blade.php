@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-md">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Portal /</span> Aduan Masyarakat Terbuka
            </h4>
            <p class="mb-4">Menampilkan data transparan dengan paginasi 10 data per halaman.</p>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function fetchLaporan(page = 1) {
            const tableBody = document.getElementById('table-body-api');
            const paginationLinks = document.getElementById('pagination-links');

            tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-5"><div class="spinner-border text-primary"></div></td></tr>';

            fetch(`/api/laporan-publik?page=${page}`)
                .then(response => response.json())
                .then(result => {
                    renderTable(result.data, result.meta.from);
                    renderPagination(result.meta, result.links);
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>';
                });
        }

        function renderTable(data, startNumber) {
            const tableBody = document.getElementById('table-body-api');
            tableBody.innerHTML = '';

            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Tidak ada laporan.</td></tr>';
                return;
            }

            data.forEach((item, index) => {
                let badgeClass = 'bg-label-primary';
                if (item.status === 'Selesai') badgeClass = 'bg-label-success';
                if (item.status === 'Diproses') badgeClass = 'bg-label-warning';
                if (item.status === 'Ditolak') badgeClass = 'bg-label-danger';

                const row = `
                    <tr>
                        <td>${startNumber + index}</td>
                        <td><strong>${item.judul_laporan}</strong></td>
                        <td><span class="text-info"><i class="bx bx-tag-alt me-1"></i>${item.kategori}</span></td>
                        <td>${item.tanggal}</td>
                        <td><span class="badge ${badgeClass}">${item.status}</span></td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        }

        function renderPagination(meta, links) {
            const paginationLinks = document.getElementById('pagination-links');
            paginationLinks.innerHTML = '';

            const prevDisabled = !links.prev ? 'disabled' : '';
            paginationLinks.innerHTML += `
                <li class="page-item ${prevDisabled}">
                    <a class="page-link" href="javascript:void(0);" data-page="${meta.current_page - 1}"><i class="tf-icon bx bx-chevron-left"></i></a>
                </li>
            `;

            // Nomor Halaman (Hanya tampilkan beberapa agar rapi)
            meta.links.forEach(link => {
                if (!isNaN(link.label)) {
                    const activeClass = link.active ? 'active' : '';
                    paginationLinks.innerHTML += `
                        <li class="page-item ${activeClass}">
                            <a class="page-link" href="javascript:void(0);" data-page="${link.label}">${link.label}</a>
                        </li>
                    `;
                }
            });

            // Tombol Next
            const nextDisabled = !links.next ? 'disabled' : '';
            paginationLinks.innerHTML += `
                <li class="page-item ${nextDisabled}">
                    <a class="page-link" href="javascript:void(0);" data-page="${meta.current_page + 1}"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
            `;

            // Tambahkan Event Listener ke setiap tombol baru
            document.querySelectorAll('.page-link').forEach(button => {
                button.addEventListener('click', function() {
                    const page = this.getAttribute('data-page');
                    if (page && page > 0 && page <= meta.last_page) {
                        fetchLaporan(page);
                    }
                });
            });
        }

        fetchLaporan(1);
    });
</script>
@endpush
