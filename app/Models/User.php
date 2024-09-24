<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\BranchScope;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

//#[ScopedBy([BranchScope::class])]
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected  $fillable = [
        'code',
        'name',
        'address',
        'email',
        'gender',
        'phone',
        'photo',
        'password',
        'join_date',
        'birth_date',
        'comment',
        'national_id',
        'marital_status_id',
        'qualification_id',
        'nationality_id',
        'branch_id',
        'job_id',
        'team_id',
        'position_id',
        'degree_id',
        'status_id',
        'category_id',
        'role',
        'apologize',
        'need_approve',
    ];

    public function scopeOwenUser(Builder $query): void
    {
        $query->where('branch_id',Auth()->user()->branch_id)->whereIn('team_id', Auth::user()->teams->pluck('id'))->orWhere('id', '=', Auth::id());
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function teams(){
        return $this->belongsToMany(Team::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function maritalStatus(){
        return $this->belongsTo(MaritalStatus::class);
    }
    public function qualification(){
        return $this->belongsTo(Qualification::class);
    }
    public function nationality(){
        return $this->belongsTo(Nationality::class);
    }
    public function job(){
        return $this->belongsTo(Job::class);
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@admin.com');

    }
}
