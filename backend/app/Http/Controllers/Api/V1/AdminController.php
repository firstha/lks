<?php

namespace App\Http\Controllers\API\\V1;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::user() instanceof Administrator) {
            return response()->json([
                'status' => 'dilarang',
                'message' => 'Anda bukan administrator',
            ], 403);
        }

        $admins = Administrator::when($request->page, function ($query) use ($request) {
            return $query->paginate($request->page);
        }, function ($query) {
            return $query->get();
        });

        return response()->json([
            'totalElement' => $admins->count(),
            'konten' => $admins,
        ]);
    }
}
