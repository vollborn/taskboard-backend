<?php

namespace App\Traits\Relations\BelongsToMany;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyPermissions
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
