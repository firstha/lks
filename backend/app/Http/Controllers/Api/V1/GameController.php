<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Game\StoreGameRequest;
use App\Http\Requests\API\V1\Game\UploadGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->page;
        $size = $request->size;
        $sortBy = $request->sortBy;
        $sortDir = $request->sortDir;

        $games = Game::when($page, function ($query) use ($page, $size, $sortBy, $sortDir) {
            return $query->orderBy($sortBy ?? 'id', $sortDir ?? 'asc')
                ->paginate($size ?? 10);
        }, function ($query) {
            return $query->get();
        });

        return response()->json([
            'totalElement' => $games->count(),
            'konten' => $games,
        ]);
    }

    public function store(StoreGameRequest $request)
    {
        $slug = Str::slug($request->title);

        $game = Game::create([
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json([
            'status' => 'berhasil',
            'slug' => $slug,
        ], 201);
    }

    public function show($slug)
    {
        $game = Game::where('slug', $slug)->first();

        if (!$game) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Game tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'game' => $game,
        ]);
    }

    public function upload(UploadGameRequest $request)
    {
        $game = Game::where('slug', $request->slug)->first();

        if (!$game) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Game tidak ditemukan',
            ], 404);
        }

        $file = $request->file('zipfile');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('games', $filename, 'public');

        $game->update([
            'zipfile' => $path,
        ]);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'File berhasil diupload',
            'path' => $path,
        ]);
    }
}
