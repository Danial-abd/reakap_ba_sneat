<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class saldomaterial extends Model
{
    use HasFactory;
    protected   $table    = 'saldo_material';
    protected   $fillable = ['id_tim', 'id_material', 'id_ba', 'jumlah', 'id_tiket', 'digunakan', 'ket','created_at'];
    public $timestamps = true;
    // protected   $primaryKey = 'kd_material';

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
            ->translatedFormat('l, d F Y ');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('teamlist', function ($query) use ($search) {
                $query->where('list_tim', 'LIKE', $search);
            });
        });

        $query->when($filters['bulan'] ?? false, function ($query, $bulan) {
            return $query->where(function($query) use ($bulan){
                $query->whereMonth('created_at', $bulan);
            });
        });
    }

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

    public function teamlist()
    {
        return $this->belongsTo(Teamlist::class,'id_tim','id');
    }

    public function teamlists()
    {
        return $this->hasOne(Teamlist::class, 'id', 'id_tim');
    }
}
