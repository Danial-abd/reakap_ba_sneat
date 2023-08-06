<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tikettim extends Model
{
    use HasFactory;
    protected $table    = 'tiket_tim';
    protected $fillable = [
        'id',
        'id_teknisi',
        'id_tim', 
        'id_j_tiket',
        'no_tiket',
        'no_inet',
        'nama_pic',
        'no_pic',
        'alamat',
        'ket',
        'latitude',
        'longitude',
        'status',
        'ketrev',
        'f_lokasi',
        'f_progress',
        'f_lap_tele',
        'created_at',
    ];

    public function scopeByMonth($query, $year, $month)
    {
        return $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
    }

    public function scopeFilter($query, array $filters)
    {
        
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->whereHas('teamdetail', function ($query) use ($search) {
                $query->whereHas('teamlist', function ($query) use ($search) {
                    $query->where('list_tim', 'LIKE', $search);
                })
                    ->orWhereHas('karyawan', function ($query) use ($search) {
                        $query->where('nama', 'LIKE', $search);
                    });
            })
                ->orWhereHas('tiketlist', function ($query) use ($search) {
                    $query->where('no_tiket', 'LIKE', $search)
                        ->orWhereHas('jenistiket', function ($query) use ($search) {
                            $query->where('nama_tiket', 'LIKE', $search);
                        });
                })->orWhere('no_tiket','LIKE',$search);
        });

        $query->when($filters['bulan'] ?? false, function ($query, $bulan) {
            return $query->where(function ($query) use ($bulan) {
                $query->whereMonth('updated_at', $bulan);
            });
        });

        $query->when($filters['tahun'] ?? false, function ($query, $tahun) {
            return $query->where(function ($query) use ($tahun) {
                $query->whereYear('updated_at', $tahun);
            });
        });

        $query->when($filters['team'] ?? false, function ($query, $team) {
            return $query->where(function ($query) use ($team) {
                $query->whereHas('teamdetail', function ($query) use ($team) {
                    $query->whereHas('teamlist', function ($query) use ($team) {
                        $query->where('list_tim', 'LIKE', $team);
                    });
                });
            });
        });

        $query->when($filters['bulan'] ?? false, function ($query, $bulan) {
            return $query->where(function ($query) use ($bulan) {
                $query->whereMonth('updated_at', $bulan);
            });
        });

        $query->when($filters['tahun'] ?? false, function ($query, $tahun) {
            return $query->where(function ($query) use ($tahun) {
                $query->whereYear('updated_at', $tahun);
            });
        });

        $query->when($filters['jtiket'] ?? false, function ($query, $jtiket) {
            return $query->where(function ($query) use ($jtiket) {
                $query->whereHas('tiketlist', function ($query) use ($jtiket) {
                    $query->whereHas('jenistiket', function ($query) use ($jtiket) {
                        $query->where('nama_tiket', 'LIKE', $jtiket);
                    });
                });
            });
        });

        // $query->when($filters['ntiket'] ?? false, function ($query, $ntiket){
        //     return $query->where(function ($query) use ($ntiket){
        //         $query->where('no_tiket','LIKE',$ntiket);
        //     });
        // });
    }
    public function ggnpenyebab(){
        return $this->belongsToMany(Ggnpenyebab::class, 'ggn_tiket', 'id_tiket', 'id_penyebab')->withPivot('ket');
    }

    // public function getCreatedAtAttribute()
    // {
    //     return Carbon::parse($this->attributes['created_at'])
    //         ->translatedFormat('l, d F Y H:i:s');
    // }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])
            ->translatedFormat('l, d F Y H:i:s');
    }

    public function teamdetail()
    {
        return $this->hasOne(Teamdetail::class, 'id_karyawan', 'id_teknisi');
    }

    public function tiketlist()
    {
        return $this->hasOne(Tiketlist::class, 'id', 'id_tiket');
    }

    public function historyrev()
    {
        return $this->belongsTo(historyrev::class, 'id_tiket','id');
    }

    public function rekapba()
    {
        return $this->hasOne(RekapBa::class, 'id_tiket', 'id');
    }

    public function jenistiket()
    {
        return $this->hasOne(jenistiket::class, 'id', 'id_j_tiket');
    }

    public function teamlist()
    {
        return $this->belongsTo(Teamlist::class, 'id_tim', 'id');
    }

    public function teamlists()
    {
        return $this->hasOne(Teamlist::class, 'id', 'id_tim');
    }

    public function saldomaterial()
    {
        return $this->hasMany(saldomaterial::class, 'id_tiket','id');
    }

    // public function teamlist()
    // {
    //     return $this->hasOneThrough(Teamlist::class, Teamdetail::class, 'id','id','id_teknisi','id');
    // }
}
