<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamdetail extends Model
{
    use HasFactory;
    protected $table    = 'teamdetail';
    protected $fillable = ['id_karyawan','id_team','id_jobdesk','ket'];
    public $timestamps = false;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search){
            return $query->whereHas('teamlist', function($query) use ($search){
                $query->where('list_tim', 'LIKE', $search);
            })
            ->orWhereHas('karyawan', function($query) use ($search){
                $query->where('nama','LIKE',$search);
            })
            ->orWhereHas('jobdesk', function($query) use ($search){
                $query->where('jobdesk','LIKE',$search);
            });
        });
    }

    public function teamlist()
    {
        return $this->belongsTo(Teamlist::class,'id_team','id');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class,'id', 'id_karyawan');
    }
    
    public function jobdesk()
    {
        return $this->belongsTo(Jobdesk::class,'id_jobdesk','id');
    }

    public function beritaacara()
    {
        return $this->hasOne(Beritaacara::class,'id_tim','id');
    }

    public function tikettim()
    {
        return $this->belongsTo(Tikettim::class,'id_teknisi','id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'role_t', 'id');
    }

    public function tiketlist()
    {
        return $this->hasManyThrough(Tiketlist::class, Tikettim::class, 'id_teknisi','id','id','id');
    }

    
}
