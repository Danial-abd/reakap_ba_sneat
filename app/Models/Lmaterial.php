<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lmaterial extends Model
{
    use HasFactory;
    protected   $table    = 'material';
    protected   $fillable = ['kd_material','nama_material'];
    // protected   $primaryKey = 'kd_material';
    public      $timestamps = false;

    //relasi
}
