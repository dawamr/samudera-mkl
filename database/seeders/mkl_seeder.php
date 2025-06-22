<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class mkl_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mkls')->insert([
            [
                'nik' => '3317042711010003',
                'nama_pribadi' => 'Ade candra adi kirana',
                'nama_mkl' => 'PT. SATU MITRA LOGISTIK',
                'nama_pt_mkl' => 'PT. SATU MITRA LOGISTIK',
                'no_telepon_pribadi' => '081327735174',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '90.486.422.0-609.000',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '332101101910005',
                'nama_pribadi' => 'ADI NUGROHO',
                'nama_mkl' => 'PT.MEGA PERSADA GLOBALINDO',
                'nama_pt_mkl' => 'PT.MEGA PERSADA GLOBALINDO',
                'no_telepon_pribadi' => '085225474881',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0627857873416000',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '334101604980061',
                'nama_pribadi' => 'RIZAL',
                'nama_mkl' => 'PT.TOPASIA INTERNASIONAL LOGISTIK',
                'nama_pt_mkl' => 'PT.TOPASIA INTERNASIONAL LOGISTIK',
                'no_telepon_pribadi' => '081779296165',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0830459616513001',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '3374022802830002',
                'nama_pribadi' => 'FEBRI',
                'nama_mkl' => 'PT.SEMARANG JAYA MITRA',
                'nama_pt_mkl' => 'PT.SEMARANG JAYA MITRA',
                'no_telepon_pribadi' => '085641041333',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0021541776503000',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '3374062001910008',
                'nama_pribadi' => 'AGIL YANUARSA',
                'nama_mkl' => 'PT. HACACA TRIJAYA LOGISTICS',
                'nama_pt_mkl' => 'PT. HACACA TRIJAYA LOGISTICS',
                'no_telepon_pribadi' => '085640725141',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0536989452518000',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '3374092501940001',
                'nama_pribadi' => 'BIMO',
                'nama_mkl' => 'PT.TOPASIA INTERNASIOANAL LOGISTIK',
                'nama_pt_mkl' => 'PT.TOPASIA INTERNASIOANAL LOGISTIK',
                'no_telepon_pribadi' => '08112698200',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0830459616513001',
                'menggunakan_mtki_payment' => 'Tidak',
                'alasan_tidak_menggunakan_mtki_payment' => 'DEPOSIT',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '3374141012780001',
                'nama_pribadi' => 'Suko sarmidi',
                'nama_mkl' => 'Pt silkargo',
                'nama_pt_mkl' => 'Pt silkargo',
                'no_telepon_pribadi' => '082241697577',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0022935878038000',
                'menggunakan_mtki_payment' => 'Tidak',
                'alasan_tidak_menggunakan_mtki_payment' => 'Deposit',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => '3374151503990003',
                'nama_pribadi' => '',
                'nama_mkl' => 'PT.KINTETSU WORLD EXPRESS INDONESIA',
                'nama_pt_mkl' => 'PT.KINTETSU WORLD EXPRESS INDONESIA',
                'no_telepon_pribadi' => '085727044667',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0021940507058000',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => 'DUMMY001',
                'nama_pribadi' => 'DJOKO',
                'nama_mkl' => 'PT. MITRA KARGO INDONESIA',
                'nama_pt_mkl' => 'PT. MITRA KARGO INDONESIA',
                'no_telepon_pribadi' => '082243350375',
                'no_telepon_kantor' => '',
                'email_kantor' => '',
                'npwp_kantor' => '0030280507509000',
                'menggunakan_mtki_payment' => 'Tidak',
                'alasan_tidak_menggunakan_mtki_payment' => 'DEPOSIT',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ],
            [
                'nik' => 'DUMMY002',
                'nama_pribadi' => 'Edy',
                'nama_mkl' => 'Pt satria lintas intermoda',
                'nama_pt_mkl' => 'PT Satria lintas intermoda',
                'no_telepon_pribadi' => '085294377631',
                'no_telepon_kantor' => '02476441443',
                'email_kantor' => '',
                'npwp_kantor' => '',
                'menggunakan_mtki_payment' => 'Ya',
                'alasan_tidak_menggunakan_mtki_payment' => '',
                'status_aktif' => 'Ya',
                'file_ktp' => '',
                'file_npwp' => ''
            ]
        ]);
    }
}
