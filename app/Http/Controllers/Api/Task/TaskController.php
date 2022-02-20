<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\TaskDeleteRequest;
use App\Http\Requests\Api\Task\TaskIndexRequest;
use App\Http\Requests\Api\Task\TaskShowRequest;
use App\Http\Requests\Api\Task\TaskStoreRequest;
use App\Http\Requests\Api\Task\TaskUpdateRequest;
use App\Http\Requests\Api\Task\TaskUpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function abort;

class TaskController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Task\TaskIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(TaskIndexRequest $request): AnonymousResourceCollection
    {
        $query = Task::query()
            ->with(['user'])
            ->scopes(['accessible'])
            ->where('project_id', $request->projectId);

        if ($request->perPage && $request->page) {
            $tasks = $query->paginate(
                perPage: $request->perPage,
                page: $request->page
            );
        } else {
            $tasks = $query->get();
        }

        return TaskResource::collection($tasks);
    }

    /**
     * @param \App\Http\Requests\Api\Task\TaskShowRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function show(TaskShowRequest $request): TaskResource
    {
        $task = Task::query()
            ->with(['user'])
            ->scopes(['accessible'])
            ->find($request->taskId);

        if (!$task) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return new TaskResource($task);
    }

    /**
     * @param \App\Http\Requests\Api\Task\TaskStoreRequest $request
     * @return \App\Http\Resources\TaskResource
     * @throws \Exception
     */
    public function store(TaskStoreRequest $request): TaskResource
    {
        $project = Project::query()
            ->scopes(['accessible'])
            ->find($request->projectId);

        if (!$project) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $task = $project->tasks()->create([
            'name'           => $request->name,
            'description'    => $request->description,
            'task_status_id' => TaskStatus::getForProject($project, $request->taskStatusId),
            'user_id'        => Auth::id()
        ]);

        return new TaskResource($task);
    }

    /**
     * @param \App\Http\Requests\Api\Task\TaskUpdateRequest $request
     * @return \App\Http\Resources\TaskResource
     * @throws \Exception
     */
    public function update(TaskUpdateRequest $request): TaskResource
    {
        $task = Task::query()
            ->with(['project'])
            ->scopes(['accessible'])
            ->find($request->taskId);

        if (!$task) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $task->name = $request->name;
        $task->description = $request->description;
        $task->task_status_id = TaskStatus::getForProject($task->project, $request->taskStatusId);
        $task->save();

        $task->unsetRelation('project');

        return new TaskResource($task);
    }

    /**
     * @param \App\Http\Requests\Api\Task\TaskUpdateStatusRequest $request
     * @return \App\Http\Resources\TaskResource
     * @throws \Exception
     */
    public function updateStatus(TaskUpdateStatusRequest $request): TaskResource
    {
        $task = Task::query()
            ->with(['project'])
            ->scopes(['accessible'])
            ->find($request->taskId);

        if (!$task) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $task->task_status_id = TaskStatus::getForProject($task->project, $request->taskStatusId);
        $task->save();

        $task->unsetRelation('project');

        return new TaskResource($task);
    }

    /**
     * @param \App\Http\Requests\Api\Task\TaskDeleteRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function delete(TaskDeleteRequest $request): TaskResource
    {
        $task = Task::query()
            ->scopes(['accessible'])
            ->find($request->taskId);

        if (!$task) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $task->delete();

        return new TaskResource($task);
    }
}
