<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_obat',
        'nama_obat',
        'kategori',
        'stok',
        'harga_jual',
        'tanggal_kadaluarsa',
        'satuan',
        'gambar_obat'
    ];

    protected $dates = ['tanggal_kadaluarsa'];
    
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_obat', 'id_obat');
    }
}
