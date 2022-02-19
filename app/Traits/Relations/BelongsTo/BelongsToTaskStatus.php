<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTaskStatus
{
    public function initializeBelongsToTaskStatus()
    {
        $this->fillable[] = 'task_status_id';
        $this->casts['task_status_id'] = 'int';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taskStatus(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
}
