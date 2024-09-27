<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaUploadRequest;
use Illuminate\Http\Request;
use App\Models\Media;

class UploadMediaController extends Controller
{
    public function uploadMedia(MediaUploadRequest $request, $message_id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
    
            $media = Media::create([
                'message_id' => $message_id,
                'file_path' => $path,
                'file_type' => $file->extension(),
            ]);
    
            return response()->json($media, 201);
        }
    
        return response()->json(['error' => 'File upload failed'], 400);
    }
}
