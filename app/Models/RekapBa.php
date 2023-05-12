<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBa extends Model
{
    use HasFactory;
    protected $table    = 'rekapberitaacara';
    protected $fillable = ['id_ba','id_tiket','id_tim'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('beritaacara', function ($query) use ($search) {
                $query->where('no_ba', 'LIKE', $search)
                    ->orWhereHas('teamdetail', function ($query) use ($search) {
                        $query->whereHas('teamlist', function ($query) use ($search) {
                            $query->where('list_tim', 'LIKE', $search);
                        });
                    });
            })
                ->orWhereHas('tikettim', function ($query) use ($search) {
                    $query->whereHas('tiketlist', function ($query) use ($search) {
                        $query->where('no_tiket', 'LIKE', $search) 
                            ->orWhereHas('jenistiket', function ($query) use ($search) {
                                $query->where('nama_tiket', 'LIKE', $search);
                            });
                    });
                });
        });

        $query->when($filters['jtiket'] ?? false, function ($query, $jtiket) {
            return $query->where(function($query) use ($jtiket){
                $query->whereHas('tikettim', function($query) use ($jtiket){
                    $query->whereHas('tiketlist', function($query) use ($jtiket){
                        $query->whereHas('jenistiket', function($query) use ($jtiket){
                            $query->where('nama_tiket',$jtiket);
                        });
                    });
                });
            });
        });

        $query->when($filters['bulan'] ?? false, function ($query, $bulan) {
            return $query->where(function($query) use ($bulan){
                $query->whereMonth('updated_at', $bulan);
            });
        });

        $query->when($filters['tahun'] ?? false, function ($query, $tahun) {
            return $query->where(function($query) use ($tahun){
                $query->whereYear('updated_at', $tahun);
            });
        });

        $query->when($filters['team'] ?? false, function ($query, $team) {
            return $query->where(function($query) use ($team){
                $query->whereHas('beritaacara', function($query) use ($team){
                    $query->whereHas('teamdetail', function($query) use ($team){
                        $query->whereHas('teamlist', function($query) use ($team){
                            $query->where('list_tim',$team);
                        });
                    });
                });
            });
        });
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d F Y H:i:s');
    }

    public function beritaacara()
    {
        return $this->belongsTo(Beritaacara::class, 'id_ba', 'id');
    }

    public function tikettim()
    {
        return $this->belongsTo(Tikettim::class, 'id_tiket', 'id');
    }

    public function teamlists() 
    {
        return $this->hasOne(Teamlist::class,'id','id_tim');
    }

    public function teamlist() {
        return $this->belongsTo(Teamlist::class,'id_tim','id');
    }
}
