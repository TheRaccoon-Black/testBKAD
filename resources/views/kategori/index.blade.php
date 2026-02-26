@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manajemen Kategori</h4>
        <button class="btn btn-primary" onclick="addKategori()">
            <i class="bx bx-plus me-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td><strong>{{ $cat->nama_kategori }}</strong></td>
                        <td>{{ Str::limit($cat->deskripsi, 50) }}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-icon btn-outline-warning me-1"
                                onclick="editKategori({{ $cat }})">
                                <i class="bx bx-edit-alt"></i>
                            </button>
                            <form action="{{ route('kategori.destroy', $cat->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Hapus kategori ini?')">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah/Edit --}}
<div class="modal fade" id="modalKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formKategori" method="POST">
            @csrf
            <div id="methodField"></div> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const modalKategori = new bootstrap.Modal(document.getElementById('modalKategori'));
    const form = document.getElementById('formKategori');

    function addKategori() {
        document.getElementById('modalTitle').innerText = 'Tambah Kategori';
        document.getElementById('methodField').innerHTML = '';
        form.action = "{{ route('kategori.store') }}";
        form.reset();
        modalKategori.show();
    }

    function editKategori(data) {
        document.getElementById('modalTitle').innerText = 'Edit Kategori';
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        form.action = `/kategori/${data.id}`;
        document.getElementById('nama_kategori').value = data.nama_kategori;
        document.getElementById('deskripsi').value = data.deskripsi;
        modalKategori.show();
    }
</script>
@endpush
