@extends('users.layout')
@section('title', 'Welcome')
@section('content')
<div class="container mb-5">
    <div class="row">
        @if(isset($keyword))
        <div class="alert alert-primary text-center mt-4" role="alert">Hasil Pencarian untuk "{{ $keyword }}"</div>
        @endif
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @if(session()->has('id'))
            @forelse($obatList as $obat)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $obat->nama_obat }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($obat->gambar_obat)
                            <img src="data:image/jpeg;base64,{{ base64_encode($obat->gambar_obat) }}" alt="Gambar Obat" class="img-fluid rounded" style="max-height: 150px;">
                            @else
                            <div class="bg-light p-4 rounded">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                            @endif
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $obat->kategori }}</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Stok
                                <span class="badge bg-primary rounded-pill">{{ $obat->stok }} {{ $obat->satuan }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Harga
                                <span class="badge bg-success rounded-pill">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Kadaluarsa
                                <span class="badge bg-warning text-dark rounded-pill">{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex flex-column">
                        <form action="{{ route('user.keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_obat" value="{{ $obat->id_obat }}">
                            <div class="input-group mb-2">
                                <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Masukkan Keranjang
                                </button>
                            </div>
                        </form>
                        <form action="{{ route('users.beli') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_obat" value="{{ $obat->id_obat }}">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-shopping-cart me-1"></i> Beli
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Tidak ada obat yang ditemukan untuk "{{ $keyword }}"
                </div>
            </div>
            @endforelse
            @else
            @forelse($obatList->take(6) as $obat)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">{{ $obat->nama_obat }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($obat->gambar_obat)
                            <img src="data:image/jpeg;base64,{{ base64_encode($obat->gambar_obat) }}" alt="Gambar Obat" class="img-fluid rounded" style="max-height: 150px;">
                            @else
                            <div class="bg-light p-4 rounded">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2 mb-0">No Image</p>
                            </div>
                            @endif
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $obat->kategori }}</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Stok
                                <span class="badge bg-primary rounded-pill">{{ $obat->stok }} {{ $obat->satuan }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Harga
                                <span class="badge bg-success rounded-pill">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Kadaluarsa
                                <span class="badge bg-warning text-dark rounded-pill">{{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d/m/Y') }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 d-flex flex-column">
                        <form action="{{ route('login') }}" method="GET">
                            @csrf
                            <input type="hidden" name="id_obat" value="{{ $obat->id_obat }}">
                            <div class="input-group mb-2">
                                <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Masukkan Keranjang
                                </button>
                            </div>
                        </form>
                        <a href="{{route('login')}}" class="btn btn-primary w-100">
                            <i class="fas fa-shopping-cart me-1"></i> Beli
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Tidak ada obat yang ditemukan untuk "{{ $keyword }}"
                </div>
            </div>
            @endforelse
            @endif
        </div>
    </div>
    @if(!session()->has('id'))
    <div class="d-flex justify-content-center mt-3 mb-3">
        <a href="{{route('login')}}" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-eye me-1"></i> Lihat Lebih Banyak
        </a>
    </div>
    @endif
</div>
@endsection