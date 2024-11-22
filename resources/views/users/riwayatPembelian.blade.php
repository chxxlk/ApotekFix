@extends('users.layout')
@section('title', 'Riwayat Pembelian')
@section('content')
<div class="container">
    <h1>Riwayat Pembelian</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Obat</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPembelian as $pembelian)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembelian->tanggal_pembelian->format('d-m-Y') }}</td>
                <td>@foreach($pembelian->detailPembelian as $dp) {{ $dp->obat->nama_obat }} @if(!$loop->last) , @endif @endforeach</td>
                <td>{{ $pembelian->detailPembelian->sum('jumlah') }}</td>
                <td>Rp. {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection