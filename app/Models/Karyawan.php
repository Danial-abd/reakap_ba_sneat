<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected   $table    = 'karyawan';
    protected   $fillable = ['nik','nama','telepon','ttl','jns_klmin','alamat'];
    public      $timestamps = false;

    public function teamdetail()
    {
        return $this->hasMany(Teamdetail::class,'id','id_karyawan');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_karyawan', 'id');
    }
}
