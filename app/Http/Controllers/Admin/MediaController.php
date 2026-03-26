<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Media/Index');
    }

    public function list()
    {
        return response()->json([
            'media' => Media::latest()->get()->map(fn ($m) => [
                'id' => $m->id,
                'url' => asset('storage/' . $m->path),
            ])
        ]);
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        $path = $file->store('media', 'public');

        $media = Media::create([
            'path' => $path,
            'disk' => 'public',
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size_bytes' => $file->getSize(),
        ]);

        return response()->json([
            'id' => $media->id,
            'url' => asset('storage/' . $media->path),
        ]);
    }
}