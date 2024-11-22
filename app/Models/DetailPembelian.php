<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembelian extends Model
{
    /**
     * Nama tabel dalam database
     *
     * @var string
     */
    protected $table = 'detail_pembelian';

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
    protected $primaryKey = 'id_detail_pembelian';

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
        'id_detail_pembelian',
        'id_pembelian',
        'id_obat',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    /**
     * Casting tipe data
     *
     * @var array
     */
    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

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
     * Relasi dengan Obat
     *
     * @return BelongsTo
     */
    public function obat(): BelongsTo
    {
        return $this->belongsTo(Obat::class, 'id_obat', 'id_obat');
    }
}