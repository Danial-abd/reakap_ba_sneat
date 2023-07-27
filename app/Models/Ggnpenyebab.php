<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ggnpenyebab extends Model
{
    protected $table = 'ggn_penyebab';
    protected $fillable = ['penyebab','job'];
    public $timestamps = false;
    use HasFactory;

    public function tikettim(){
        return $this->belongsToMany(Tikettim::class, 'ggn_tiket', 'id_penyebab', 'id_tiket');
    }

}
