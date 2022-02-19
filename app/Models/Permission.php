<?php

namespace App\Models;

use App\Traits\Relations\BelongsToMany\BelongsToManyUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory,
        BelongsToManyUsers;

    protected $fillable = [
        'name'
    ];
}
