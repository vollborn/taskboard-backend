<?php

namespace App\Models;

use App\Traits\Relations\BelongsToMany\BelongsToManyUsers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Permission extends Model
{
    use HasFactory,
        BelongsToManyUsers;

    protected $fillable = [
        'name'
    ];

    public const MANAGEMENT_USER_READ = 'management.user.read';
    public const MANAGEMENT_USER_CREATE = 'management.user.create';
    public const MANAGEMENT_USER_UPDATE = 'management.user.update';
    public const MANAGEMENT_USER_DELETE = 'management.user.delete';

    public const MANAGEMENT_PROJECT_READ = 'management.project.read';
    public const MANAGEMENT_PROJECT_CREATE = 'management.project.create';
    public const MANAGEMENT_PROJECT_UPDATE = 'management.project.update';
    public const MANAGEMENT_PROJECT_DELETE = 'management.project.delete';

    public const TASK_CREATE = 'task.create';
    public const TASK_UPDATE = 'task.update';
    public const TASK_DELETE = 'task.delete';

    /**
     * @return array
     */
    public static function getAllNames(): array
    {
        $reflector = new ReflectionClass(__CLASS__);
        return array_diff($reflector->getConstants(), $reflector->getParentClass()->getConstants());
    }
}
