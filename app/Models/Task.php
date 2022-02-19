<?php /** @noinspection PhpHierarchyChecksInspection */

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToProject;
use App\Traits\Relations\BelongsTo\BelongsToTaskStatus;
use App\Traits\Relations\BelongsTo\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccessible(Builder $query): Builder
    {
        return $query->whereHas('project', static function (Builder $query) {
            $query->scopes(['accessible']);
        });
    }
}
