@extends('admin.layout')
@section('title', 'Edit Obat Page')
@section('content')

<div class="container">
    <h2>Edit Obat</h2>
    <form action="{{ route('admin.obat.update', $obat->id_obat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_obat">Nama Obat</label>
            <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $obat->nama_obat) }}" required>
            @error('nama_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <input type="text" class="form-control @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori', $obat->kategori) }}" required>
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok', $obat->stok) }}" required>
            @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $obat->harga_jual) }}" required>
            @error('harga_jual')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
            <input type="date" class="form-control @error('tanggal_kadaluarsa') is-invalid @enderror" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}" required>
            @error('tanggal_kadaluarsa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $obat->satuan) }}" required>
            @error('satuan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="gambar_obat">Gambar Obat</label>
            <input type="file" class="form-control-file @error('gambar_obat') is-invalid @enderror" id="gambar_obat" name="gambar_obat">
            @error('gambar_obat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($obat->gambar_obat)
                <img src="data:image/jpeg;base64,{{ base64_encode($obat->gambar_obat) }}" alt="Gambar Obat" class="img-thumbnail mt-2" style="max-width: 200px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Obat</button>
    </form>
</div>
@endsection