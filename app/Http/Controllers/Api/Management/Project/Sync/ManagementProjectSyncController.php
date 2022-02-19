<?php

namespace App\Http\Controllers\Api\Management\Project\Sync;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\Project\Sync\ManagementProjectSyncUsersRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ManagementProjectSyncController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\Project\Sync\ManagementProjectSyncUsersRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function users(ManagementProjectSyncUsersRequest $request): ProjectResource
    {
        /** @var Project $project */
        $project = Project::query()->find($request->projectId);
        $project->users()->sync($request->userIds ?? []);

        return new ProjectResource($project);
    }
}
