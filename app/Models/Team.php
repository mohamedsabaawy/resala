<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable =['name','manager_id','count'];

    public function manager(){
        return $this->belongsTo(User::class,'manager_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
