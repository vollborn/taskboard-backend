<?php

namespace App\Http\Controllers\Api\Management\User\Sync;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\User\Sync\ManagementUserSyncPermissionsRequest;
use App\Http\Requests\Api\Management\User\Sync\ManagementUserSyncProjectsRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class ManagementUserSyncController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\User\Sync\ManagementUserSyncProjectsRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function projects(ManagementUserSyncProjectsRequest $request): UserResource
    {
        /** @var User $user */
        $user = User::query()->find($request->userId);
        $user->projects()->sync($request->projectIds ?? []);

        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\Api\Management\User\Sync\ManagementUserSyncPermissionsRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function permissions(ManagementUserSyncPermissionsRequest $request): UserResource
    {
        /** @var User $user */
        $user = User::query()->find($request->userId);
        $user->permissions()->sync($request->permissionIds ?? []);

        return new UserResource($user);
    }
}
