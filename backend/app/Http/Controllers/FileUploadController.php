<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400',
        ]);
        $path = $request->file('file')->store('build', 'public');

        return response()->json([
            'message' => 'Upload berhasil!',
            'path' => $path
        ]);
    }
}
