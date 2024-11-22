@extends('users.layout')
@section('title', 'Report Detail Pembelian')
@section('content')
<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Detail Pembelian Terakhir</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tanggal Pembelian</th>
                            <td>{{ $pembelian->tanggal_pembelian->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp. {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    <h4>Daftar Obat</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian->detailPembelian as $detail)
                            <tr>
                                <td>{{ $detail->obat->nama_obat }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <a href="{{ route('user.keranjang.show') }}" class="btn btn-secondary">Kembali</a>
                        <button onclick="window.print()" class="btn btn-primary">Cetak Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    @media print {
        .card-header, .text-right {
            display: none;
        }
    }
</style>
@endsection