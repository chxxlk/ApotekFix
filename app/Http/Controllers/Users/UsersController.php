<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Obat;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailPembelian;
use App\Models\Pembelian;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $keyword = $request->input('search');
            $obatList = Obat::where('nama_obat', 'LIKE', '%' . $keyword . '%')
                ->orWhere('kategori', 'LIKE', '%' . $keyword . '%')
                ->get();
        } else {
            $obatList = Obat::all();
            $keyword = null;
        }

        $response = response()->view('users.dashboard', compact('obatList', 'keyword'));
        $response->headers->add([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Fri, 01 Jan 1990 00:00:00 GMT',
        ]);

        return $response;
    }
    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', ['user' => $user]);
    }
    public function show()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users', compact('users'));
    }
    public function riwayatPembelian()
    {
        $riwayatPembelian = Pembelian::with('user', 'detailPembelian.obat')
            ->where('id_user', Auth::id())
            ->orderBy('tanggal_pembelian', 'desc')
            ->get();
        $detailPembelian = DetailPembelian::with('obat')
            ->get();
        return view('users.riwayatPembelian',[
            'riwayatPembelian' => $riwayatPembelian,
            'detailPembelian' => $detailPembelian
        ]);
    }
}
