<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektortim extends Model
{
    public $table = 'sektor_tim';
    public $fillable = ['id_sektor','id_tim'];
    public $timestamps = false;
    use HasFactory;



}
