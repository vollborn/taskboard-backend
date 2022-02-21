<?php

namespace App\Http\Controllers\Api\Management\Permission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Management\Permission\ManagementPermissionIndexRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ManagementPermissionController extends Controller
{
    /**
     * @param \App\Http\Requests\Api\Management\Permission\ManagementPermissionIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(ManagementPermissionIndexRequest $request): AnonymousResourceCollection
    {
        $query = Permission::query();

        if ($request->hasUserId) {
            $query->whereHas('users', static function ($query) use ($request) {
                $query->where('id', $request->hasUserId);
            });
        }

        if ($request->doesntHaveUserId) {
            $query->whereDoesntHave('users', static function ($query) use ($request) {
                $query->where('id', $request->doesntHaveUserId);
            });
        }

        if ($request->perPage && $request->page) {
            $permissions = $query->paginate(
                perPage: $request->perPage,
                page: $request->page
            );
        } else {
            $permissions = $query->get();
        }

        return PermissionResource::collection($permissions);
    }
}
