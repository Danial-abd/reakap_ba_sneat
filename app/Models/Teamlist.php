<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamlist extends Model
{
    use HasFactory;
    protected $table    = 'teamlist';
    protected $fillable = ['list_tim'];
    public $timestamps = false;

    public function teamdetail()
    {
        return $this->hasOne(Teamdetail::class,'id_team','id');
    }

    public function tiketlist() {
        return $this->hasManyThrough(Tiketlist::class, Teamdetail::class ,'id_team','id_teknisi','id','id');
    }

    public function tikettim() {
        return $this->hasOne(Tikettim::class,'id','id_tim');
    }

    public function tikettims() {
        return $this->belongsTo(Tikettim::class,'id','id_tim');
    }

    public function rekapbas() {
        return $this->belongsTo(RekapBa::class,'id','id_tim');
    }

    public function rekapba() {
        return $this->hasOne(RekapBa::class,'id','id_tim');
    }

    public function ba() {
        return $this->belongsTo(Beritaacara::class,'id','id_tl');
    }

    // public function saldomaterial() {
    //     return $this->belongsTo(saldomaterial::class,'id','id_tim');
    // }
    public function saldomaterial()
    {
        return $this->hasMany(saldomaterial::class,'id_tim','id');
    }



    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['jtiket'] ?? false, function ($query, $jtiket) {
            return $query->where(function($query) use ($jtiket){
                $query->whereHas('tikettims', function($query) use ($jtiket){
                    $query->whereHas('teamdetail', function($query) use ($jtiket){
                        $query->whereHas('jobdesk', function($query) use ($jtiket){
                            $query->where('detail_kerja', $jtiket);
                        });
                    });
                });
            });
        });
    }
}
