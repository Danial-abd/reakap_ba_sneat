<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ggntiket extends Model
{
    use HasFactory;
    protected $table = 'ggn_tiket';
    protected $fillable = ['id_penyebab','id_tiket','ket'];
    public $timestamps = false;
}
