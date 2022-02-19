<?php

namespace App\Traits\Relations\BelongsToMany;

use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyProjects
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
