<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\SignInRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(SignInRequest $request)
    {
        $userToken = $this->authenticateAsUser($request);

        if ($userToken) {
            return response()->json([
                'status' => 'berhasil',
                'token' => $userToken,
            ]);
        }

        $adminToken = $this->authenticateAsAdministrator($request);

        if ($adminToken) {
            return response()->json([
                'status' => 'berhasil',
                'token' => $adminToken,
            ]);
        }

        return response()->json([
            'status' => 'tidak valid',
            'message' => 'Nama pengguna atau sandi salah'
        ], 401);
    }

    protected function authenticateAsAdministrator(SignInRequest $request)
    {
        if (Auth::guard('administrator')->attempt($request->toArray())) {
            $user = Auth::guard('administrator')->user();
            $token = $user->createToken('Administrator Token')->plainTextToken;

            return $token;
        }

        return null;
    }

    protected function authenticateAsUser(SignInRequest $request)
    {
        if (Auth::guard('user')->attempt($request->toArray())) {
            $user = Auth::guard('user')->user();
            $token = $user->createToken('User Token')->plainTextToken;

            return $token;
        }

        return null;
    }
}
