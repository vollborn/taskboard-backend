<?php

namespace App\Http\Controllers\Api\Management\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\User\ManagementUserDeleteRequest;
use App\Http\Requests\Api\Management\User\ManagementUserIndexRequest;
use App\Http\Requests\Api\Management\User\ManagementUserShowRequest;
use App\Http\Requests\Api\Management\User\ManagementUserStoreRequest;
use App\Http\Requests\Api\Management\User\ManagementUserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ManagementUserController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\User\ManagementUserIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ManagementUserIndexRequest $request): AnonymousResourceCollection
    {
        $query = User::query();

        if ($request->hasProjectId) {
            $query->whereHas('projects', static function ($query) use ($request) {
                $query->where('id', $request->hasProjectId);
            });
        }

        if ($request->doesntHaveProjectId) {
            $query->whereDoesntHave('projects', static function ($query) use ($request) {
                $query->where('id', $request->doesntHaveProjectId);
            });
        }

        if ($request->perPage && $request->page) {
            $users = $query->paginate(
                perPage: $request->perPage,
                page: $request->page
            );
        } else {
            $users = $query->get();
        }

        return UserResource::collection($users);
    }

    /**
     * @param \App\Http\Requests\Api\Management\User\ManagementUserShowRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function show(ManagementUserShowRequest $request): UserResource
    {
        $user = User::query()->find($request->userId);

        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\Api\Management\User\ManagementUserStoreRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function store(ManagementUserStoreRequest $request): UserResource
    {
        $user = User::query()->create([
            'username'   => $request->username,
            'first_name' => $request->firstName,
            'last_name'  => $request->lastName,
            'password'   => Hash::make($request->password)
        ]);

        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\Api\Management\User\ManagementUserUpdateRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function update(ManagementUserUpdateRequest $request): UserResource
    {
        $user = User::query()->find($request->userId);

        $user->username = $request->username;
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;

        if ($request->password) {
            $user->forceFill([
                'password'  => Hash::make($request->password),
                'api_token' => null
            ]);
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\Api\Management\User\ManagementUserDeleteRequest $request
     * @return \App\Http\Resources\UserResource
     */
    public function delete(ManagementUserDeleteRequest $request): UserResource
    {
        if ($request->userId == User::ADMIN_ID) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = User::query()->find($request->userId);
        $user->delete();

        return new UserResource($user);
    }
}
