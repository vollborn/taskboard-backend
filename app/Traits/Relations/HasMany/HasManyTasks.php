<?php

namespace App\Traits\Relations\HasMany;

use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyTasks
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
