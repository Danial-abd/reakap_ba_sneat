<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Beritaacara extends Model
{
    use HasFactory;
    protected $table    = 'beritaacara';
    protected $fillable = ['no_ba', 'id_tim', 'file_ba','id_tl'];

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
            ->translatedFormat('l, d F Y H:i:s');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where(function ($query) use ($search) {
                $query->where('no_ba', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('teamdetail', function($query) use ($search){
                        $query->whereHas('teamlist', function($query) use ($search){
                            $query->where('list_tim', 'LIKE', $search);
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
                $query->whereHas('teamdetail', function($query) use ($team){
                    $query->whereHas('teamlist', function($query) use ($team){
                        $query->where('list_tim', 'LIKE', $team);
                    });
                });
            });
        });
    }

    public function teamdetail()
    {
        return $this->belongsTo(Teamdetail::class, 'id_tim', 'id');
    }

    public function rekapba()
    {
        return $this->hasOne(RekapBa::class, 'id_ba', 'id');
    }

    public function teamlist() 
    {
        return $this->hasOne(Teamlist::class,'id','id_tl');
    }
}
