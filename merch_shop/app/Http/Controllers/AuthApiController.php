<?php

namespace App\Http\Controllers;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\BaseLoginApiRequest;
use App\Http\Requests\BaseRegisterApiRequest;
use Illuminate\Support\Carbon;
use Auth;
use Hash;
use App\Models\User;
use App\OpenApi\Parameters\AuthLoginSubmitParameters;
use App\OpenApi\Parameters\AuthRegisterSubmitParameters;
use App\OpenApi\Responses\UserTokenResponse;
use App\OpenApi\Responses\UserLogoutResponse;
use App\OpenApi\Responses\UserResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use Doctrine\DBAL\Schema\Schema;

#[OpenApi\PathItem]
class AuthApiController extends Controller
{
    /**
     * Display user data.
     *
     * @return \Illuminate\Http\Responsable
     */
    #[OpenApi\Operation(tags: ["auth"])]
    #[OpenApi\Response(factory: UserResponse::class, statusCode: 200)]
    function user(Request $request) {
        return $request->user();
    }
    /**
     * Save appeal submitted data
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method:'POST')]
    #[OpenApi\Response(factory: UserLogoutResponse::class, statusCode: 200)]
    public function logout(Request $request)
    {

        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json('Successfully logged out');
    }
    /**
     * Save appeal submitted data
     * @param BaseRegisterApiRequest
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method:'POST')]
    #[OpenApi\Parameters(factory: AuthRegisterSubmitParameters::class)]
    #[OpenApi\Response(factory: UserTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    public function register(BaseRegisterApiRequest $request)
    {
        $data = $request->validated();

        $user = User::query()
        ->where('email', $data['email'])
        ->first();

        if ($user) {
            $user = User::changeFromRequest($user, $data);
        } else {
            $user = User::createFormRequest($data);
        }
        $authToken = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $authToken,
        ]);
    }
    /**
     * Save appeal submitted data
     * @param BaseLoginApiRequest
     * @return JsonResponse
     */
    #[OpenApi\Operation(tags: ["auth"], method:'POST')]
    #[OpenApi\Parameters(factory: AuthLoginSubmitParameters::class)]
    #[OpenApi\Response(factory: UserTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    public function login(BaseLoginApiRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data, true)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => ['Invalid email'],
                    'password' => ['Invalid credentials'],
                ]
            ], 422);
        }
        $user = Auth::user();
        $user->app_logged_in_at = Carbon::now();
        $user->save();
        $authToken = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'access_token' => $authToken,
        ]);
    }

}
