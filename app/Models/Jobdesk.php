<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobdesk extends Model
{
    use HasFactory;
    protected $table    = 'jobdesk';
    protected $fillable = ['kd_jd','jobdesk','detail_kerja'];
    public $timestamps = false;

    public function teamdetail()
    {
        return $this->hasOne(Teamdetail::class,'id_jobdesk','id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'role','id');
    }
}

