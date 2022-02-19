<?php

namespace App\Models;

use App\Traits\Relations\BelongsToMany\BelongsToManyUsers;
use App\Traits\Relations\HasMany\HasManyTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory,
        BelongsToManyUsers,
        HasManyTasks;

    protected $fillable = [
        'name',
        'description'
    ];
}
