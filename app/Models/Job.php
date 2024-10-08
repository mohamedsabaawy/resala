<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

#[ScopedBy([BranchScope::class])]
class Job extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =['name','manager_id','branch_id'];


    public function manager(){
        return $this->belongsTo(User::class,'manager_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function links()
    {
        return $this->belongsToMany(Link::class);
    }
}
