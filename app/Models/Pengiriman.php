<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'pengiriman';
    protected $fillable = [
        'pos_id',
        'no_register',
        'status',
        'pemilik',
        'alamat_rumah',
        'alamat_pengirim',
        'hp',
        'no_perkara',
        'no_akta',
        'tanggal_akta',
        'resi',
        'tanggal_terkirim',
    ];

    public function pos(){
        return $this->belongsTo(pos::class);
    }
}
