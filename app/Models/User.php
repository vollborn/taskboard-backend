<?php

namespace App\Models;

use App\Traits\Relations\BelongsToMany\BelongsToManyPermissions;
use App\Traits\Relations\BelongsToMany\BelongsToManyProjects;
use App\Traits\Relations\BelongsToMany\BelongsToManyUsers;
use App\Traits\Relations\HasMany\HasManyTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        BelongsToManyUsers,
        BelongsToManyPermissions,
        BelongsToManyProjects,
        HasManyTasks;

    public const ADMIN_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @param string $permission
     * @return bool
     */
    public static function authorize(string $permission): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->permissions()->where('name', $permission)->exists();
    }
}
