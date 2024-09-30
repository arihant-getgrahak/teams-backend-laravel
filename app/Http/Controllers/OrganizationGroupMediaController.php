<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\Models\OrganizationGroupMedia;
use App\Models\OrganizationGroup;
use Auth;
class OrganizationGroupMediaController extends Controller
{
    public function uploadOrganizationMedia(OrganizationGroupMedia $request)
    {
        $organizationGroup = OrganizationGroup::findOrFail($request->organization_group_id);
        $organizationId = $organizationGroup->organization_id; // Fetch related organization_id

        $sendersId = Auth::id();

        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadGroupImage($file);
                    $filePath = $fileurl;

                    $media = OrganizationGroupMedia::create([
                        'filename' => $filename,
                        'file_path' => $filePath,
                        'organization_group_id' => $request->organization_group_id,
                        'organization_id' => $organizationId,
                        'senders_id' => $sendersId,

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

            $media = OrganizationGroupMedia::create([
                'filename' => $filename,
                'file_path' => $filePath,
                'organization_group_id' => $request->organization_group_id,
                'organization_id' => $organizationId,
                'senders_id' => $sendersId,

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

    protected function uploadGroupImage($file)
    {
        $uploadFolder = 'group_media';
        $image = $file;
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageUrl = Storage::disk('public')->url($image_uploaded_path);

        return $uploadedImageUrl;
    }
}
