<?php

namespace App\Traits\Relations\BelongsTo;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait BelongsToUser
{
    public function initializeBelongsToUser()
    {
        $this->fillable[] = 'user_id';
        $this->casts['user_id'] = 'int';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
