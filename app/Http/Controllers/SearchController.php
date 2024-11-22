<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
class SearchController extends Controller
{
    public function usersSearch_notLogin(Request $request)
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
        return view('welcome', compact('obatList', 'keyword'));
    }
}
