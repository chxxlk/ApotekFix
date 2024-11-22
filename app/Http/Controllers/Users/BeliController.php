<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Users\CheckOutController;
use Exception;

class BeliController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'id_obat' => 'required|exists:obat,id_obat',
        ]);
        $validated['id_user'] = Auth::id();

        DB::beginTransaction();
        try {
            $obat = Obat::findOrFail($request->id_obat);
            if ($obat->stok < 1) {
                return redirect()->back()->with('error', 'Stok obat tidak cukup');
            }

            $pembelian = Pembelian::create([
                'id_pembelian' => CheckOutController::generateIDPembelian(),
                'id_user' => Auth::id(),
                'tanggal_pembelian' => Carbon::now(),
                'total_harga' => $obat->harga_jual,
            ]);

            DetailPembelian::create([
                'id_detail_pembelian' => CheckOutController::generateIDDetailPembelian(),
                'id_pembelian' => $pembelian->id_pembelian,
                'id_obat' => $obat->id_obat,
                'jumlah' => 1,
                'harga_satuan' => $obat->harga_jual,
                'subtotal' => $obat->harga_jual,
            ]);

            $obat = Obat::find($obat->id_obat);
            $obat->stok -= 1;
            $obat->save();

            $penjualan = Penjualan::create([
                'id_penjualan' => CheckOutController::generateIDPenjualan(),
                'id_pembelian' => $pembelian->id_pembelian,
                'tanggal_penjualan' => Carbon::now(),
                'id_user' => Auth::id(),
                'total_harga' => $obat->harga_jual,
            ]);

            DetailPenjualan::create([
                'id_detail_penjualan' => CheckOutController::generateIDDetailPenjualan(),
                'id_penjualan' => $penjualan->id_penjualan,
                'id_obat' => $obat->id_obat,
                'id_pembelian' => $pembelian->id_pembelian,
                'jumlah' => 1,
                'harga_satuan' => $obat->harga_jual,
                'subtotal' => $obat->harga_jual,
            ]);

            DB::commit();

            return redirect(route('users.dashboard'))->with('success', 'Obat berhasil dibeli');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect(route('users.dashboard'))->with('error', 'Obat gagal dibeli');
        }
    }
}
