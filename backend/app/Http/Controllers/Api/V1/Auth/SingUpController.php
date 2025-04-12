<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SingUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(SignUpRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('User Token')->plainTextToken;

        return response()->json([
            'status' => 'berhasil',
            'token' => $token,
        ]);
    }
}
