<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToProject
{
    public function initializeBelongsToProject()
    {
        $this->fillable[] = 'project_id';
        $this->casts['project_id'] = 'int';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
