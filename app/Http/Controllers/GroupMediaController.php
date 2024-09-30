<?php

namespace App\Http\Controllers;
use Storage;
use App\Models\GroupMedia;
use App\Http\Requests\GroupMediaRequest;
class GroupMediaController extends Controller
{
    public function uploadGroupMedia(GroupMediaRequest $request)
    {
        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadGroupImage($file);
                    $filePath = $fileurl;

                    $media = GroupMedia::create([
                        'filename' => $filename,
                        'file_path' => $filePath,
                        'group_id' => $request->group_id,

                    ]);

                    $mediaFiles[] = $media;
                }
                return response()->json([
                    'message' => 'Files uploaded successfully',
                    'media' => $mediaFiles
                ], 200);
            }

            $filename = time() . '-' . $request->file('file')->getClientOriginalName();
            $fileurl = $this->uploadGroupImage($request->file('file'));
            $filePath = $fileurl;

            $media = GroupMedia::create([
                'filename' => $filename,
                'file_path' => $filePath,
                'group_id' => $request->group_id,

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

    protected function uploadGroupImage($file)
    {
        $uploadFolder = 'group_media';
        $image = $file;
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageUrl = Storage::disk('public')->url($image_uploaded_path);

        return $uploadedImageUrl;
    }
}
