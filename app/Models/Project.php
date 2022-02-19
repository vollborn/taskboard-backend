<?php

namespace App\Models;

use App\Traits\Relations\BelongsToMany\BelongsToManyUsers;
use App\Traits\Relations\HasMany\HasManyTasks;
use App\Traits\Relations\HasMany\HasManyTaskStatuses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use HasFactory,
        BelongsToManyUsers,
        HasManyTaskStatuses,
        HasManyTasks;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessible(Builder $query): Builder
    {
        return $query->whereHas('users', static function ($query) {
            $query->where('id', Auth::id());
        });
    }
}
