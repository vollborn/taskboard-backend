<?php /** @noinspection PhpHierarchyChecksInspection */

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToProject;
use App\Traits\Relations\BelongsTo\BelongsToTaskStatus;
use App\Traits\Relations\BelongsTo\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory,
        BelongsToProject,
        BelongsToUser,
        BelongsToTaskStatus;

    protected $fillable = [
        'name',
        'description'
    ];
}
