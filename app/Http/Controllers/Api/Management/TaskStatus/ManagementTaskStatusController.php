<?php

namespace App\Http\Controllers\Api\Management\TaskStatus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusDeleteRequest;
use App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusIndexRequest;
use App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusShowRequest;
use App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusStoreRequest;
use App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusUpdateRequest;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagementTaskStatusController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ManagementTaskStatusIndexRequest $request): AnonymousResourceCollection
    {
        $query = TaskStatus::query()
            ->where('project_id', $request->projectId);

        if ($request->perPage && $request->page) {
            $projects = $query->paginate(
                perPage: $request->perPage,
                page: $request->page
            );
        } else {
            $projects = $query->get();
        }

        return TaskStatusResource::collection($projects);
    }

    /**
     * @param \App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusShowRequest $request
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function show(ManagementTaskStatusShowRequest $request): TaskStatusResource
    {
        $taskStatus = TaskStatus::query()->find($request->taskStatusId);

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusStoreRequest $request
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function store(ManagementTaskStatusStoreRequest $request): TaskStatusResource
    {
        $taskStatus = TaskStatus::query()->create([
            'project_id' => $request->projectId,
            'name'       => $request->name,
            'color'      => $request->color,
            'order'      => $request->order ?? TaskStatus::getNextOrder($request->projectId)
        ]);

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusUpdateRequest $request
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function update(ManagementTaskStatusUpdateRequest $request): TaskStatusResource
    {
        $taskStatus = TaskStatus::query()->find($request->taskStatusId);

        $taskStatus->order = $request->order;
        $taskStatus->name = $request->name;
        $taskStatus->color = $request->color;

        $taskStatus->save();

        return new TaskStatusResource($taskStatus);
    }

    /**
     * @param \App\Http\Requests\Api\Management\TaskStatus\ManagementTaskStatusDeleteRequest $request
     * @return \App\Http\Resources\TaskStatusResource
     */
    public function delete(ManagementTaskStatusDeleteRequest $request): TaskStatusResource
    {
        /** @var TaskStatus $taskStatus */
        $taskStatus = TaskStatus::query()->find($request->taskStatusId);

        $next = TaskStatus::query()
            ->where('id', '<>', $request->taskStatusId)
            ->orderBy('order')
            ->first();

        if ($next) {
            $taskStatus->tasks()->update([
                'task_status_id' => $next->id
            ]);
        }

        $taskStatus->delete();

        return new TaskStatusResource($taskStatus);
    }
}
