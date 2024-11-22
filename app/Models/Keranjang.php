<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Obat;

class Keranjang extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_user',
        'id_obat',
        'jumlah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}
