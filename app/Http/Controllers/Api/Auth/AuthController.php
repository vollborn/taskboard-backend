<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthInfoRequest;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
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
     * @param AuthInfoRequest $request
     * @return UserResource
     */
    public function info(AuthInfoRequest $request): UserResource
    {
        /** @var User $user */
        $user = Auth::user();
        $user->loadMissing(['permissions']);

        return new UserResource($user);
    }

    /**
     * @param AuthLoginRequest $request
     * @return Response|UserResource
     */
    public function login(AuthLoginRequest $request): Response|AuthResource
    {
        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return $this->code(Response::HTTP_CONFLICT);
        }

        if (!Hash::check($request->password, $user->password)) {
            return $this->code(Response::HTTP_CONFLICT);
        }

        $apiToken = Str::random(128);
        $user->forceFill([
            'api_token' => $apiToken
        ]);
        $user->save();

        $user->loadMissing(['permissions']);

        return new AuthResource($user);
    }
}
