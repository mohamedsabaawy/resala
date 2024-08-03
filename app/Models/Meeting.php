<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;//meeting

    protected $fillable = ['title','date','count','comment','status','user_id','add_by','position_id','team_id','branch_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
}
