<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\ProjectIndexRequest;
use App\Http\Requests\Api\Project\ProjectShowRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Project\ProjectIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ProjectIndexRequest $request): AnonymousResourceCollection
    {
        $projects = Project::query()
            ->scopes(['accessible'])
            ->paginate(
                perPage: $request->perPage,
                page: $request->page
            );

        return ProjectResource::collection($projects);
    }

    /**
     * @param \App\Http\Requests\Api\Project\ProjectShowRequest $request
     * @return \App\Http\Resources\ProjectResource
     */
    public function show(ProjectShowRequest $request): ProjectResource
    {
        $project = Project::query()
            ->with([
                'taskStatuses' => static function (HasMany $query) {
                    $query->orderBy('order');
                }
            ])
            ->scopes(['accessible'])
            ->find($request->projectId);

        if (!$project) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return new ProjectResource($project);
    }
}
