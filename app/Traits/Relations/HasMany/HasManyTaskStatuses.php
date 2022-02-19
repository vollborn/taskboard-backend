<?php

namespace App\Traits\Relations\HasMany;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyTaskStatuses
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taskStatuses(): HasMany
    {
        return $this->hasMany(TaskStatus::class);
    }
}
