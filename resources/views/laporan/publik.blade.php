@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-md">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Portal /</span> Aduan Masyarakat Terbuka
            </h4>
            <p class="mb-4">Monitor aduan masyarakat dan berikan tanggapan langsung secara real-time.</p>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Daftar Laporan Terkini</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul Laporan</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body-api" class="table-border-bottom-0">
                    {{-- Diisi via JS --}}
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

<div class="modal fade" id="modalTanggapi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Detail & Berikan Tanggapan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="bg-label-primary p-3 rounded mb-4">
                    <div class="d-flex justify-content-between mb-2 border-bottom border-primary pb-2">
                        <small class="text-uppercase fw-bold text-primary">Isi Laporan:</small>
                        <small class="text-muted text-uppercase">Pelapor: <strong id="tampil_pelapor" class="text-dark">-</strong></small>
                    </div>
                    <p id="tampil_isi" class="mb-0 text-dark" style="white-space: normal;"></p>
                </div>

                <h6>Riwayat Tanggapan</h6>
                <div id="list_tanggapan" class="mb-4" style="max-height: 250px; overflow-y: auto;">
                </div>

                <hr>
                <form action="{{ route('tanggapan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="laporan_id" id="lap_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-primary">Tanggapan Anda (Petugas.)</label>
                        <textarea name="tanggapan" class="form-control" rows="3" placeholder="Tulis instruksi atau jawaban..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kirim Tanggapan</button>
                </form>
            </div>
        </div>
    </div>
    <form id="form-delete" action="" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
</div>

@endsection

@push('scripts')
<script>
    function hapusLaporan(id) {
        if (confirm('Apakah Anda yakin ingin menghapus laporan ini?')) {
            const form = document.getElementById('form-delete');
            form.action = '/laporan/' + id;
            form.submit();
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('modalTanggapi');
        if (!modalEl) return console.error('HTML Modal tidak ditemukan!');

        const modalTanggapi = new bootstrap.Modal(modalEl);

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
                <td><span class="badge bg-label-info">${item.kategori}</span></td>
                <td class="text-nowrap">${item.tanggal}</td>
                <td><span class="badge ${badgeClass}">${item.status}</span></td>
                <td class="text-center">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-primary btn-tanggapi" data-id="${item.id}">
                            Detail
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="hapusLaporan(${item.id})">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>`;
        tableBody.innerHTML += row;
    });

    document.querySelectorAll('.btn-tanggapi').forEach(btn => {
        btn.addEventListener('click', function() {
            openModalTanggapi(this.getAttribute('data-id'));
        });
    });
}

        function openModalTanggapi(id) {
            const listTanggapan = document.getElementById('list_tanggapan');
            const tampilIsi = document.getElementById('tampil_isi');
            const tampilPelapor = document.getElementById('tampil_pelapor');
            const inputLapId = document.getElementById('lap_id');

            tampilIsi.innerText = 'Memuat...';
            tampilPelapor.innerText = '...';
            listTanggapan.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

            modalTanggapi.show();

            fetch(`/api/laporan/${id}`)
                .then(response => response.json())
                .then(result => {
                    const data = result.data;
                    tampilIsi.innerText = data.isi_laporan;
                    tampilPelapor.innerText = data.pelapor.nama;
                    inputLapId.value = data.id;

                    let html = '';
                    if (data.daftar_tanggapan.length > 0) {
                        data.daftar_tanggapan.forEach(t => {
                            html += `
                                <div class="card bg-label-secondary mb-2 border-0 shadow-none">
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold small text-primary"><i class="bx bx-user-voice me-1"></i>${t.petugas}</span>
                                            <small class="text-muted" style="font-size: 0.7rem;">${t.tgl_tanggapan}</small>
                                        </div>
                                        <p class="mb-0 small text-dark">${t.isi_tanggapan}</p>
                                    </div>
                                </div>`;
                        });
                    } else {
                        html = '<div class="text-center text-muted my-3 small italic">Belum ada riwayat tanggapan.</div>';
                    }
                    listTanggapan.innerHTML = html;
                });
        }

        function renderPagination(meta, links) {
            const paginationLinks = document.getElementById('pagination-links');
            paginationLinks.innerHTML = '';
            meta.links.forEach(link => {
                const activeClass = link.active ? 'active' : '';
                const disabledClass = !link.url ? 'disabled' : '';
                let label = link.label.replace('&laquo; ', '').replace(' &raquo;', '');
                if(label === 'Previous') label = '<i class="bx bx-chevron-left"></i>';
                if(label === 'Next') label = '<i class="bx bx-chevron-right"></i>';

                paginationLinks.innerHTML += `
                    <li class="page-item ${activeClass} ${disabledClass}">
                        <a class="page-link shadow-none" href="javascript:void(0);" data-url="${link.url}">${label}</a>
                    </li>`;
            });

            document.querySelectorAll('.page-link').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    if(url) fetchLaporan(new URL(url).searchParams.get('page'));
                });
            });
        }

        fetchLaporan(1);
    });
</script>
@endpush
