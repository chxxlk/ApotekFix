<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    public function index(Request $request)
    {   
        $obatList = Obat::all();
        return view('admin.obat', compact('obatList'));
    }
    public function create()
    {
        return view('admin.obat.create');
    }
    private static function generateIDObat()
    {
        $latestObat = Obat::orderBy('id_obat', 'desc')->first();
        if ($latestObat) {
            $latestId = $latestObat->id_obat;
            $number = (int) substr($latestId, 3); // Get the numeric part
            $newId = 'OBT' . str_pad($number + 1, 3, '0', STR_PAD_LEFT); // Increment and pad with zeros
        } else {
            $newId = 'OBT001';
        }
        return $newId;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'tanggal_kadaluarsa' => 'required|date',
            'satuan' => 'required',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['id_obat'] = $this->generateIdObat();

        if ($request->hasFile('gambar_obat')) {
            $image = $request->file('gambar_obat');
            $validated['gambar_obat'] = file_get_contents($image->getRealPath());
        }

        Obat::create($validated);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil ditambahkan');
    }
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_obat' => 'required',
            'kategori' => 'required',
            'stok' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'tanggal_kadaluarsa' => 'required|date',
            'satuan' => 'required',
            'gambar_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $obat = Obat::findOrFail($id);

        if ($request->hasFile('gambar_obat')) {
            $image = $request->file('gambar_obat');
            $validated['gambar_obat'] = file_get_contents($image->getRealPath());
        }

        $obat->update($validated);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil diperbarui');
    }


    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil dihapus');
    }
}
