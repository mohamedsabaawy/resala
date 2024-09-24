<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Models\Scopes\BranchScope;


#[ScopedBy([BranchScope::class])]
class Role extends SpatieRole
{
//    protected static function booted()
//    {
//        static::addGlobalScope(new BranchScope);
//    }
}
