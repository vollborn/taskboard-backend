<?php /** @noinspection PhpHierarchyChecksInspection */

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToProject;
use App\Traits\Relations\HasMany\HasManyTasks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory,
        HasManyTasks,
        BelongsToProject;

    protected $fillable = [
        'name',
        'color'
    ];
}
