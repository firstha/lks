<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->page, function ($query) use ($request) {
            return $query->paginate($request->page);
        }, function ($query) {
            return $query->get();
        });

        return response()->json([
            'totalElement' => $users->count(),
            'konten' => $users,
        ]);
    }
}
