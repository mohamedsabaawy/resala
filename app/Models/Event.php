<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

#[ScopedBy([BranchScope::class])]
class Event extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =['name','details','from','to','team_id','type','active','job_id','branch_id'];



}
