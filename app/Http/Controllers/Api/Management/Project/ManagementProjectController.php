<?php

namespace App\Http\Controllers\Api\Management\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\Project\ManagementProjectDeleteRequest;
use App\Http\Requests\Api\Management\Project\ManagementProjectIndexRequest;
use App\Http\Requests\Api\Management\Project\ManagementProjectShowRequest;
use App\Http\Requests\Api\Management\Project\ManagementProjectStoreRequest;
use App\Http\Requests\Api\Management\Project\ManagementProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagementProjectController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\Project\ManagementProjectIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ManagementProjectIndexRequest $request): AnonymousResourceCollection
    {
        $projects = Project::query()->paginate(
            perPage: $request->perPage,
            page: $request->page
        );

        return ProjectResource::collection($projects);
    }

    /**
     * @param \App\Http\Requests\Api\Management\Project\ManagementProjectShowRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(ManagementProjectShowRequest $request): ProjectResource
    {
        $project = Project::query()->find($request->projectId);

        return new ProjectResource($project);
    }

    /**
     * @param \App\Http\Requests\Api\Management\Project\ManagementProjectStoreRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function store(ManagementProjectStoreRequest $request): ProjectResource
    {
        $project = Project::query()->create([
            'name'        => $request->name,
            'description' => $request->description
        ]);

        return new ProjectResource($project);
    }

    /**
     * @param \App\Http\Requests\Api\Management\Project\ManagementProjectUpdateRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function update(ManagementProjectUpdateRequest $request): ProjectResource
    {
        $project = Project::query()->find($request->projectId);

        $project->name = $request->name;
        $project->description = $request->description;

        $project->save();

        return new ProjectResource($project);
    }

    /**
     * @param \App\Http\Requests\Api\Management\Project\ManagementProjectDeleteRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function delete(ManagementProjectDeleteRequest $request): ProjectResource
    {
        $project = Project::query()->find($request->projectId);
        $project->delete();

        return new ProjectResource($project);
    }
}
