<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

#[ScopedBy([BranchScope::class])]
class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['name','branch_id'];

//    public function scopeBranchScope($query): void
//    {
//        $query->where('branch_id','=', Auth::user()->branch_id);
//    }
}
