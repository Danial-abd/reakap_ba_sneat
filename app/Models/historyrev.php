<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyrev extends Model
{
    use HasFactory;
    protected $table    = 'history_revisi';
    protected $fillable = ['id_tiket','status','ketrev'];
    public $timestamps = true;

    public function tikettim()
    {
        return $this->hasOne(Tikettim::class, 'id','id_tiket');
    }
}
