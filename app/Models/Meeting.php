<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Meeting extends Model
{
    use HasFactory;//meeting

    protected $fillable = ['title','date','count','comment','status','user_id','add_by','position_id','team_id','branch_id','job_id'];


    public function scopeBranchScope($query): void
    {
        $query->where('branch_id','=', Auth::user()->branch_id);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
}
