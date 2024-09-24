<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([BranchScope::class])]
class Team extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable =['name','manager_id','count','branch_id'];

    public function manager(){
        return $this->belongsTo(User::class,'manager_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
