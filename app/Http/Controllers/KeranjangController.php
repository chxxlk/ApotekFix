<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
class KeranjangController extends Controller
{
    public function show()
    {
        $keranjang = Keranjang::with('obat')->where('id_user', Auth::id())->get();
        $total = $keranjang->sum(function ($item) {
            return $item->jumlah * $item->obat->harga_jual;
        });

        return view('users.keranjang', compact('keranjang', 'total'));
    }
    private static function generateIDKeranjang()
    {
        $latestKeranjang = Keranjang::orderBy('id', 'desc')->first();
        if ($latestKeranjang) {
            $latestId = $latestKeranjang->id;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'KRJ' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'KRJ001';
        }
        return $newId;
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'id_obat' => 'required|exists:obat,id_obat',
            'jumlah' => 'required|integer|min:1',
        ]);
        $validated['id'] = $this->generateIdKeranjang();
        $validated['id_user'] = Auth::id();

        // Cek apakah item sudah ada di keranjang
        $keranjangItem = Keranjang::where('id_user', Auth::id())
            ->where('id_obat', $request->id_obat)
            ->first();

        if ($keranjangItem) {
            // Jika sudah ada, tambahkan jumlahnya
            $keranjangItem->jumlah += $request->jumlah;
            $keranjangItem->save();
        } else {
            // Jika belum ada, buat item baru di keranjang
            Keranjang::create($validated);
        }

        return redirect()->route('users.dashboard')->with('success','berhasil ditambahkan ke keranjang');
    }
    public function destroy($id)
    {
        $keranjang = Keranjang::where('id', $id)->where('id_user', Auth::id())->first();

        if ($keranjang) {
            $keranjang->delete();
            return redirect()->route('user.keranjang.show')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('user.keranjang.show')->with('error', 'Item tidak ditemukan.');
    }
    public function reportDetailPembelian(Request $request)
    {
        // Ambil data pembelian terakhir user yang sedang login
        $userId = Auth::id();
        $pembelian = Pembelian::where('id_user', $userId)
            ->latest('tanggal_pembelian')
            ->first();

        if (!$pembelian) {
            return redirect()->back()->with('error', 'Tidak ada data pembelian');
        }

        // Ambil detail pembelian
        $detailPembelian = DetailPembelian::where('id_pembelian', $pembelian->id)
            ->with('obat')
            ->get();

        return view('users.reportDetailPembelian', [
            'pembelian' => $pembelian,
            'detailPembelian' => $detailPembelian
        ]);
    }
}
