@extends('users.layout')
@section('title', 'Keranjang')
@section('content')
<div class="container">
    <h1>Keranjang Obat</h1>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success') }}
    </div>
    @elseif(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{session()->get('error')}}
    </div>
    @endif
    <a href="{{ route('user.keranjang.report') }}" class="btn btn-info">Lihat Invoice Terakhir</a>
    @if ($keranjang->isEmpty())
    <p>Keranjang Anda kosong.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjang as $item)
            <tr>
                <td>{{ $item->obat->nama_obat }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>Rp {{ number_format($item->obat->harga_jual, 2, ',', '.') }}</td>
                <td>Rp {{ number_format($item->jumlah * $item->obat->harga_jual, 2, ',', '.') }}</td>
                <td>
                    <form action="{{ route('user.keranjang.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: Rp {{ number_format($total, 2, ',', '.') }}</h3>

    <form action="{{route('users.keranjang.checkout')}}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Checkout</button>
    </form>
    @endif
</div>
@endsection