<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get Auth Mode
     *
     * Memberikan informasi ke frontend apakah menggunakan SSO (NexaID) atau Local Login.
     *
     * @unauthenticated
     * @tags Authentication
     */
    public function getAuthMode()
    {
        return response()->json([
            'sso_enabled' => config('iam.enabled', false),
            'sso_login_url' => config('iam.enabled') ? route('iam.sso.login') : null,
        ]);
    }

    /**
     * User Login
     *
     * Autentikasi pengguna menggunakan NIP dan password untuk mendapatkan Bearer Token.
     *
     * @unauthenticated
     * @tags Authentication
     * @response 200 {
     *    "message": "Login berhasil",
     *    "token": "1|token-string",
     *    "user": {}
     * }
     * @response 401 {
     *    "message": "NIP atau password salah"
     * }
     * @response 403 {
     *    "message": "User tidak aktif"
     * }
     */
    public function login(StoreAuthRequest $request)
    {
        $request->validated();

        if (!Auth::attempt($request->only('nip', 'password'))) {
            return response()->json([
                'message' => 'NIP atau password salah'
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'User tidak aktif'
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->load('roles');

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => $user
        ]);
    }

    /**
     * Get Authenticated User
     */
    public function me(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('[DEBUG] auth/me dipanggil', [
            // Apakah ada Bearer token di header?
            'has_authorization_header' => $request->hasHeader('Authorization'),
            'authorization'            => $request->header('Authorization') ? 'Bearer ***' : null,

            // Cookie yang masuk
            'cookies'                  => array_keys($request->cookies->all()),

            // Session info
            'session_id'               => $request->session()->getId(),
            'session_has_data'         => !empty($request->session()->all()),

            // Guard aktif
            'guard_web_check'          => \Illuminate\Support\Facades\Auth::guard('web')->check(),
            'guard_sanctum_check'      => \Illuminate\Support\Facades\Auth::guard('sanctum')->check(),

            // User dari request (via sanctum middleware)
            'user_from_request'        => optional($request->user())->id ?? 'null (tidak terautentikasi)',

            // IAM config
            'iam_enabled'              => config('iam.enabled'),
            'sanctum_stateful_domains' => config('sanctum.stateful'),

            // Request info
            'request_host'             => $request->getHost(),
            'request_origin'           => $request->header('Origin'),
        ]);

        $user = $request->user();
        $user->load('roles');

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * User Logout
     *
     * Menghapus (revoke) token yang saat ini digunakan, sehingga sesi pengguna berakhir.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
