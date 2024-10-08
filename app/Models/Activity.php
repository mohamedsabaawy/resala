<?php

namespace App\Models;

use App\Models\Scopes\BranchScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//#[ScopedBy([BranchScope::class])]
class Activity extends Model
{
    //approval = 0 not approve || 1 approved || 2 refused
    use HasFactory, SoftDeletes;

    protected $fillable = ['activity_date', 'user_id', 'event_id', 'add_by', 'type', 'apologize', 'comment', 'supervisor_comment', 'approval', 'manager_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
