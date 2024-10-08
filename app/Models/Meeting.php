<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
#[ScopedBy([BranchScope::class])]
class Meeting extends Model
{
    use HasFactory;//meeting

    protected $fillable = ['title','date','count','comment','status','user_id','add_by','position_id','team_id','branch_id','job_id'];

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
