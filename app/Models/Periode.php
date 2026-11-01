<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'periode';

    /**
     * Kolom yang dapat diisi massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'periode',
        'singkatan',
        'status',
    ];

    /**
     * Tipe konversi atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }
}
