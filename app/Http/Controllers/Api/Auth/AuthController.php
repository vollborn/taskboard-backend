<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthLogoutRequest;
use App\Http\Requests\Api\Auth\AuthShowRequest;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
use App\Http\Requests\Api\Auth\AuthUpdateRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param AuthShowRequest $request
     * @return UserResource
     */
    public function show(AuthShowRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->loadMissing(['permissions']);

        return new UserResource($user);
    }

    /**
     * @param AuthUpdateRequest $request
     * @return UserResource
     */
    public function update(AuthUpdateRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->save();

        return new UserResource($user);
    }

    /**
     * @param AuthLoginRequest $request
     * @return Response|UserResource
     */
    public function login(AuthLoginRequest $request): Response|AuthResource
    {
        $user = User::query()->where('username', $request->username)->first();
        if (!$user) {
            abort(Response::HTTP_CONFLICT);
        }

        if (!Hash::check($request->password, $user->password)) {
            abort(Response::HTTP_CONFLICT);
        }

        $apiToken = Str::random(128);
        $user->forceFill([
            'api_token' => $apiToken
        ]);
        $user->save();

        $user->loadMissing(['permissions']);

        return new AuthResource($user);
    }

    /**
     * @param AuthLogoutRequest $request
     * @return UserResource
     */
    public function logout(AuthLogoutRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->forceFill([
            'api_token' => null
        ]);
        $user->save();

        return new UserResource($user);
    }
}
