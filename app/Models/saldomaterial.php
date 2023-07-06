<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saldomaterial extends Model
{
    use HasFactory;
    protected   $table    = 'saldo_material';
    protected   $fillable = ['id_tim', 'id_material', 'id_ba', 'jumlah', 'id_tiket', 'digunakan','ket'];
    // protected   $primaryKey = 'kd_material';

    




    public function material()
    {
        return $this->hasOne(Lmaterial::class, 'id', 'id_material');
    }

    public function ba()
    {
        return $this->belongsTo(Beritaacara::class, 'id_ba', 'id');
    }

    public function ba2()
    {
        return $this->hasOne(Beritaacara::class, 'id', 'id_ba');
    }

    public function tikettim()
    {
        return $this->belongsTo(Tikettim::class, 'id_tiket', 'id');
    }

    // public function teamlist()
    // {
    //     return $this->hasOne(Teamlist::class, 'id', 'id_tim');
    // }

    public function teamlist()
    {
        return $this->belongsTo(Teamlist::class, 'id_tim', 'id');
    }
}
