<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiketlist extends Model
{
    use HasFactory;
    protected $table    = 'tiketlist';
    protected $fillable = ['no_tiket', 'nama_pic', 'no_pic', 'alamat', 'ket', 'id_j_tiket'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where (function($query) use ($search){
                $query->where('nama_pic', 'LIKE', '%' . $search . '%')
                ->orWhere('no_tiket', 'LIKE', '%' . $search . '%');
            });
        });
 
        $query->when($filters['bulan'] ?? false, function ($query, $bulan) {
            return $query->where(function($query) use ($bulan){
                $query->whereMonth('created_at', $bulan);
            });
        });

        $query->when($filters['tahun'] ?? false, function ($query, $tahun) {
            return $query->where(function($query) use ($tahun){
                $query->whereYear('created_at', $tahun);
            });
        });

        // $bln = date('m');

        // $query->when($filters['bln'], function ($query, $bln){
        //     return $query->where(function($query) use ($bln){
        //         $query->whereMonth('updated_at', $bln);
        //     });
        // });
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d F Y');
    }

    public function jenistiket()
    {
        return $this->belongsTo(Jenistiket::class, 'id_j_tiket', 'id');
    }

    public function beritaacara()
    {
        return $this->hasOne(RekapBa::class, 'id_tiket', 'id');
    }

    public function tikettim()
    {
        return $this->belongsTo(Tikettim::class, 'id','id_tiket');
    }
}
