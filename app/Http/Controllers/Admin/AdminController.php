<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Obat;
use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $obats = Obat::all();
        $totalUsers = User::count();
        $totalObat = Obat::count();
        $totalPenjualan = Penjualan::sum('total_harga');

        $detailPenjualan = DetailPenjualan::with('obat')
            ->get();
        $penjualanTerbaru = Penjualan::with(['user', 'detailPenjualan.obat'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();
        $obatHampirHabis = Obat::where('stok', '<', 10)->get();
        
        $response = response()->view('admin.dashboard', [
            'user' => $user,
            'totalUsers' => $totalUsers,
            'totalObat' => $totalObat,
            'totalPenjualan' => $totalPenjualan,
            'penjualanTerbaru' => $penjualanTerbaru,
            'obatHampirHabis' => $obatHampirHabis,
            'detailPenjualan' => $detailPenjualan,
            'tampilkanUsers' => $users,
            'tampilkanObat' => $obats,
        ]);
        $response->headers->add([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
        ]);

        return $response;
    }
}
