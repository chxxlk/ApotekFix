<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CheckOutController extends Controller
{
    public static function generateIDPembelian()
    {
        $latestPembelian = Pembelian::orderBy('id_pembelian', 'desc')->first();
        if ($latestPembelian) {
            $latestId = $latestPembelian->id_pembelian;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'PMB' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'PMB001';
        }
        return $newId;
    }
    public static function generateIDDetailPembelian()
    {
        $latestDetailPembelian = DetailPembelian::orderBy('id_detail_pembelian', 'desc')->first();
        if ($latestDetailPembelian) {
            $latestId = $latestDetailPembelian->id_detail_pembelian;
            $number = (int) substr($latestId, 3); // Ambil bagian numerik
            $newId = 'DPM' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment dan pad dengan nol
        } else {
            $newId = 'DPM001'; // ID awal
        }
        return $newId;
    }
    public static function generateIDPenjualan()
    {
        $latestPenjualan = Penjualan::orderBy('id_penjualan', 'desc')->first();
        if ($latestPenjualan) {
            $latestId = $latestPenjualan->id_penjualan;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'PJN' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'PJN001';
        }
        return $newId;
    }
    public static function generateIDDetailPenjualan()
    {
        $latestDetailPenjualan = DetailPenjualan::orderBy('id_detail_penjualan', 'desc')->first();
        if ($latestDetailPenjualan) {
            $latestId = $latestDetailPenjualan->id_detail_penjualan;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'DPJ' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'DPJ001';
        }
        return $newId;
    }
    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            // Ambil keranjang user yang sedang login
            $keranjang = Keranjang::where('id_user', Auth::id())->get();

            if ($keranjang->isEmpty()) {
                return redirect()->route('users.keranjang.show')->with('error', 'Keranjang Anda kosong.');
            }

            // Hitung total harga
            $totalHarga = 0;
            foreach ($keranjang as $item) {
                $totalHarga += $item->jumlah * $item->obat->harga_jual;
            }

            // Simpan data pembelian
            $pembelian = Pembelian::create([
                'id_pembelian' => $this->generateIDPembelian(),
                'id_user' => Auth::id(),
                'tanggal_pembelian' => Carbon::now(),
                'total_harga' => $totalHarga,
            ]);

            // Simpan detail pembelian dan update stok obat
            foreach ($keranjang as $item) {
                DetailPembelian::create([
                    'id_detail_pembelian' => $this->generateIDDetailPembelian(),
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_obat' => $item->id_obat,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->obat->harga_jual,
                    'subtotal' => $item->jumlah * $item->obat->harga_jual,
                ]);
                // Kurangi stok obat
                $obat = Obat::find($item->id_obat);
                $obat->stok -= $item->jumlah;
                $obat->save();
            }

            // Simpan data penjualan
            $penjualan = Penjualan::create([
                'id_penjualan' => $this->generateIDPenjualan(),
                'id_pembelian' => $pembelian->id_pembelian,
                'tanggal_penjualan' => Carbon::now(),
                'id_user' => Auth::id(),
                'total_harga' => $totalHarga,
            ]);

            // Simpan detail penjualan
            foreach ($keranjang as $item) {
                DetailPenjualan::create([
                    'id_detail_penjualan' => $this->generateIDDetailPenjualan(),
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_obat' => $item->id_obat,
                    'id_pembelian' => $pembelian->id_pembelian,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->obat->harga_jual,
                    'subtotal' => $item->jumlah * $item->obat->harga_jual,
                ]);
            }

            // Hapus keranjang setelah checkout
            Keranjang::where('id_user', Auth::id())->delete();
            DB::commit();

            return redirect()->route('user.keranjang.show')->with('success', 'Checkout berhasil.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('user.keranjang.show')->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
