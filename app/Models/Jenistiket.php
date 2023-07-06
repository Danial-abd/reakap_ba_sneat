<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenistiket extends Model
{
    use HasFactory;
    protected $table    = 'jenistiket';
    protected $fillable = ['nama_tiket'];
    public $timestamps = false;


    public function tiketlist()
    {
        return $this->hasOne(Tiketlist::class,'id_j_tiket','id');
    }

    public function jobdesk()
    {
        return $this->belongsTo(jobdesk::class,'detail_kerja','id');
    }

    public function tikettim()
    {
        return $this->belongsTo(tikettim::class,'id_j_tiket','id');
    }
}
