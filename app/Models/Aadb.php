<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aadb extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "t_aadb";
    protected $primaryKey = "id_aadb";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'kategori_id',
        'nup',
        'jenis_aadb',
        'kualifikasi',
        'merk_tipe',
        'no_polisi',
        'no_bpkb',
        'tanggal_perolehan',
        'nilai_perolehan',
        'nilai_alokasi',
        'kondisi_id',
        'keterangan',
        'foto_barang',
        'status'
    ];

    public function uker() {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function kategori() {
        return $this->belongsTo(AadbKategori::class, 'kategori_id');
    }

    public function kondisi() {
        return $this->belongsTo(AadbKondisi::class, 'kondisi_id');
    }
}
