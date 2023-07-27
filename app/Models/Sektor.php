<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory;
    protected   $table    = 'sektor';
    protected   $fillable = ['sektor'];
    public $timestamps = false;

    public function teamlist(){
        return $this->belongsToMany(Teamlist::class, 'sektor_tim', 'id_sektor', 'id_tim');
    }

}
