<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use Illuminate\Http\Request;
use App\Models\Media;
use Storage;

class MediaController extends Controller
{
    public function uploadMedia(Request $request)
    {
        $mediaFiles = [];
        if ($request->hasFile('file')) {
            if (is_array($request->file('file'))) {
                foreach ($request->file('file') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadImage($file);
                    $filePath = $fileurl;

                    $media = Media::create([
                        'filename' => $filename,
                        'file_path' => $filePath,

                        'receiver_id' => $request->receiver_id,
                        // 'group_id' => $request->group_id ?? "dd",

                    ]);

                    $mediaFiles[] = $media;
                }
                return response()->json([
                    'message' => 'Files uploaded successfully',
                    'media' => $mediaFiles
                ], 200);
            }

            $filename = time() . '-' . $request->file('file')->getClientOriginalName();
            $fileurl = $this->uploadImage($request->file('file'));
            $filePath = $fileurl;

            $media = Media::create([
                'filename' => $filename,
                'file_path' => $filePath,

                'receiver_id' => $request->receiver_id,
                // 'group_id' => $request->group_id ?? "dd",

            ]);
            return response()->json([
                'message' => 'Files uploaded successfully',
                'media' => $media
            ], 200);
        } else {
            return response()->json([
                'message' => 'Please upload file',
                'status' => "false"
            ], status: 400);
        }
    }

    // check kr

    protected function uploadImage($file)
    {
        $uploadFolder = 'media';
        $image = $file;
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageUrl = Storage::disk('public')->url($image_uploaded_path);

        return $uploadedImageUrl;
    }
}
