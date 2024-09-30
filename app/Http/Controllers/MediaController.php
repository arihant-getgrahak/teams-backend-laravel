<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use Illuminate\Http\Request;
use App\Models\Media;
use Storage;
use App\Models\OrganizationGroupMedia;
use App\Models\OrganizationGroup;
use Auth;
use App\Models\GroupMedia;
use App\Http\Requests\GroupMediaRequest;
use App\Http\Requests\OrganizationGroupMediaRequest;
use App\Models\Organization;
use App\Models\OrganizationTwoPersonMedia;

class MediaController extends Controller
{
    public function uploadMedia(Request $request)
    {
        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadImage($file);
                    $filePath = $fileurl;

                    $media = Media::create([
                        'filename' => $filename,
                        'file_path' => $filePath,

                        'receiver_id' => $request->receiver_id,
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

    public function uploadOrganizationMedia(OrganizationGroupMediaRequest $request)
    {
        $organizationGroup = OrganizationGroup::findOrFail($request->organization_group_id);
        $organizationId = $organizationGroup->organization_id; // Fetch related organization_id

        $sendersId = Auth::id();

        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadImage($file);
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
            $fileurl = $this->uploadImage($request->file('file'));
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

    public function uploadGroupMedia(GroupMediaRequest $request)
    {
        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {
                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadImage($file);
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
            $fileurl = $this->uploadImage($request->file('file'));
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

    public function OrganizationTwoPersonMedia(Request $request)
    {
        $sender = auth()->id();
        $organizationId = $request->organization_id;
        $receiverId = $request->receiver_id;

        $organization = Organization::findOrFail($organizationId);

        if (!$organization->users()->where('user_id', $sender)->exists()) {
            // Log::error('Sender does not belong to this organization');
            return response()->json([
                'message' => 'Sender does not belong to the specified organization',
                'status' => 'false'
            ], 403);
        }

        if (!$organization->users()->where('user_id', $receiverId)->exists()) {
            // Log::error('Receiver does not belong to this organization');
            return response()->json([
                'message' => 'Receiver does not belong to the specified organization',
                'status' => 'false'
            ], 403);
        }

        $mediaFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $filename = time() . '-' . $file->getClientOriginalName();
                $filePath = $file->storeAs('organization-media', $filename, 'public'); // Save to the 'organization-media' folder

                $media = OrganizationTwoPersonMedia::create([
                    'filename' => $filename,
                    'file_path' => $filePath,
                    'sender_id' => $sender,
                    'receiver_id' => $receiverId,
                    'organization_id' => $organizationId,
                ]);

                $mediaFiles[] = $media;
            }

            return response()->json([
                'message' => 'Files uploaded successfully',
                'media' => $mediaFiles
            ], 200);
        }

        return response()->json(['message' => 'No files uploaded'], 400);
    }

    public function getAllMediaByOrganization($lang, $organizationId)
    {
        $media = OrganizationTwoPersonMedia::where('organization_id', $organizationId)->get();

        if ($media->isEmpty()) {
            return response()->json([
                'message' => 'No media found for the specified organization',
                'status' => 'false'
            ], 404);
        }

        return response()->json([
            'message' => 'Media retrieved successfully',
            'media' => $media
        ], 200);
    }

    public function getAllMediaByGroup($lang, $groupId)
    {

        $media = OrganizationGroupMedia::where('organization_group_id', $groupId)->get();

        if ($media->isEmpty()) {
            return response()->json([
                'message' => 'No media found for the specified group',
                'status' => 'false'
            ], 404);
        }

        return response()->json([
            'message' => 'Media retrieved successfully',
            'media' => $media
        ], 200);
    }

    public function getAllMediaForTwoPersons($lang, $organizationId, $senderId, $receiverId)
    {
        $media = OrganizationTwoPersonMedia::where('organization_id', $organizationId)
            ->where('sender_id', $senderId)
            ->where('receiver_id', $receiverId)
            ->get();

        if ($media->isEmpty()) {
            return response()->json([
                'message' => 'No media found between the specified users in the organization',
                'status' => 'false'
            ], 404);
        }

        return response()->json([
            'message' => 'Media retrieved successfully',
            'media' => $media
        ], 200);
    }

    public function getMediaByReceiver($lang, $receiverId)
    {
        $mediaFiles = Media::where('receiver_id', $receiverId)->get();

        if ($mediaFiles->isEmpty()) {
            return response()->json([
                'message' => 'No media found for the specified receiver',
                'status' => 'false'
            ], 404);
        }

        return response()->json([
            'message' => 'Media retrieved successfully',
            'media' => $mediaFiles
        ], 200);
    }

    protected function uploadImage($file)
    {
        $uploadFolder = 'media';
        $image = $file;
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageUrl = Storage::disk('public')->url($image_uploaded_path);

        return $uploadedImageUrl;
    }
}
