<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;

class GenerateIDController extends Controller
{
    public static function generateIDPembelian()
    {
        $latestKeranjang = Pembelian::orderBy('id_pembelian', 'desc')->first();
        if ($latestKeranjang) {
            $latestId = $latestKeranjang->id;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'PMB' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'PMB001';
        }
        return $newId;
    }
    public static function generateIDDetailPembelian()
    {
        $latestKeranjang = DetailPembelian::orderBy('id_detail_pembelian', 'desc')->first();
        if ($latestKeranjang) {
            $latestId = $latestKeranjang->id;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'D-PMB' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'D-PMB001';
        }
        return $newId;
    }
    public static function generateIDPenjualan()
    {
        $latestKeranjang = Penjualan::orderBy('id_penjualan', 'desc')->first();
        if ($latestKeranjang) {
            $latestId = $latestKeranjang->id;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'PJN' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'PJN001';
        }
        return $newId;
    }
    public static function generateIDDetailPenjualan()
    {
        $latestKeranjang = DetailPenjualan::orderBy('id_detail_penjualan', 'desc')->first();
        if ($latestKeranjang) {
            $latestId = $latestKeranjang->id;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'D-PJN' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'D-PJN001';
        }
        return $newId;
    }
}
