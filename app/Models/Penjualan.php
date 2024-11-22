<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    /**
     * Nama tabel dalam database
     *
     * @var string
     */
    protected $table = 'penjualan';

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
    protected $primaryKey = 'id_penjualan';

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
        'id_penjualan',
        'id_pembelian',
        'tanggal_penjualan',
        'id_user',
        'total_harga'
    ];

    /**
     * Casting tipe data
     *
     * @var array
     */
    protected $casts = [
        'tanggal_penjualan' => 'datetime',
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
     * Relasi dengan Pembelian
     *
     * @return BelongsTo
     */
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id_pembelian');
    }

    /**
     * Relasi dengan Detail Penjualan
     *
     * @return HasMany
     */
    public function detailPenjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'id_penjualan', 'id_penjualan');
    }
}