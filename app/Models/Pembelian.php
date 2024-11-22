<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    /**
     * Nama tabel dalam database
     *
     * @var string
     */
    protected $table = 'pembelian';

    /**
     * Nonaktifkan timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Primary key dari tabel
     *
     * @var string
     */
    protected $primaryKey = 'id_pembelian';

    /**
     * Tipe primary key
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Nonaktifkan incrementing
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Kolom yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'id_pembelian',
        'id_user',
        'tanggal_pembelian',
        'total_harga'
    ];

    /**
     * Casting tipe data
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pembelian' => 'datetime',
        'total_harga' => 'decimal:2'
    ];

    /**
     * Relasi dengan User
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi dengan Detail Pembelian
     *
     * @return HasMany
     */
    public function detailPembelian(): HasMany
    {
        return $this->hasMany(DetailPembelian::class, 'id_pembelian', 'id_pembelian');
    }

    /**
     * Relasi dengan Penjualan
     *
     * @return HasMany
     */
    public function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'id_pembelian', 'id_pembelian');
    }
}