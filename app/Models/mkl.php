<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mkl extends Model
{
    use HasFactory;

    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'nama_pribadi',
        'nama_mkl',
        'nama_pt_mkl',
        'no_telepon_pribadi',
        'no_telepon_kantor',
        'email_kantor',
        'npwp_kantor',
        'menggunakan_mtki_payment',
        'alasan_tidak_menggunakan_mtki_payment',
        'status_aktif',
        'file_ktp',
        'file_npwp'
    ];
}
