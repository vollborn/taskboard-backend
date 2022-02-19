<?php /** @noinspection PhpHierarchyChecksInspection */

namespace App\Models;

use App\Traits\Relations\BelongsTo\BelongsToProject;
use App\Traits\Relations\HasMany\HasManyTasks;
use Exception;
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

    /**
     * @throws \Exception
     */
    public static function getForProject(Project $project, ?int $taskStatusId): int
    {
        if (
            !$taskStatusId
            || !$project->taskStatuses()->where('id', $taskStatusId)->exists()
        ) {
            return static::getProjectDefault($project);
        }

        return $taskStatusId;
    }

    /**
     * @param \App\Models\Project $project
     * @return int
     * @throws \Exception
     */
    public static function getProjectDefault(Project $project): int
    {
        $taskStatus = $project->taskStatuses()->orderBy('order')->first();
        if (!$taskStatus) {
            throw new Exception("Could not get project default task status for project with id: " . $project->id);
        }

        return $taskStatus->id;
    }
}
