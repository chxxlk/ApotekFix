@extends('admin.layout')
    @section('title', 'Obat Page')
    @section('content')
    <div class="container-fluid mt-3">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Obat</h6>
                <a href="{{ route('admin.obat.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Obat
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Harga Jual</th>
                                <th>Tanggal Kadaluarsa</th>
                                <th>Gambar Obat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($obatList as $index => $obat)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->kategori }}</td>
                                <td>{{ $obat->stok }}</td>
                                <td>{{ $obat->satuan }}</td>
                                <td>Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') }}</td>
                                <td>@if($obat->gambar_obat)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($obat->gambar_obat) }}" alt="Gambar Obat" class="img-thumbnail" style="max-width: 100px;">
                                    @else
                                    No Image
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.obat.edit', $obat->id_obat) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.obat.destroy', $obat->id_obat) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
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
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
    @endpush
    @endsection
    </body>

    </html>