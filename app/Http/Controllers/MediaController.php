<?php

namespace App\Http\Controllers;
use App\Models\User;
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
        $validate = $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        if (!$validate) {
            return response()->json([
                'message' => "Receiver id is required",
                'status' => 'false'
            ], 403);
        }


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

            $filename = time() . '-' . $request->file('files')->getClientOriginalName();
            $fileurl = $this->uploadImage($request->file('files'));
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
        $organizationGroup = OrganizationGroup::find($request->organization_group_id);
        if (!$organizationGroup) {
            return response()->json([
                'message' => 'Group not found',
                'status' => "false"
            ], status: 400);
        }
        $organizationId = $organizationGroup->organization_id;

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

            $filename = time() . '-' . $request->file('files')->getClientOriginalName();
            $fileurl = $this->uploadImage($request->file('files'));
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
        $sender_id = auth()->user()->id;
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
                        "sender_id" => $sender_id
                    ]);

                    $mediaFiles[] = $media;
                }
                return response()->json([
                    'message' => 'Files uploaded successfully',
                    'media' => $mediaFiles
                ], 200);
            }

            $filename = time() . '-' . $request->file('files')->getClientOriginalName();
            $fileurl = $this->uploadImage($request->file('files'));
            $filePath = $fileurl;

            $media = GroupMedia::create([
                'filename' => $filename,
                'file_path' => $filePath,
                'group_id' => $request->group_id,
                "sender_id" => $sender_id

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
        $validate = $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        if (!$validate) {
            return response()->json([
                'message' => "Receiver id is required",
                'status' => 'false'
            ], 403);
        }
        $sender = auth()->id();
        $user = User::with('organizations')->where('id', $sender)->first();

        if ($user->organizations[0]["id"] == null) {
            return response()->json(['message' => 'Organization not found'], 404);
        }

        $receiverId = $request->receiver_id;


        $mediaFiles = [];
        if ($request->hasFile('files')) {
            if (is_array($request->file('files'))) {
                foreach ($request->file('files') as $file) {

                    $filename = time() . '-' . $file->getClientOriginalName();
                    $fileurl = $this->uploadImage($file);
                    $filePath = $fileurl;

                    $media = OrganizationTwoPersonMedia::create([
                        'filename' => $filename,
                        'file_path' => $filePath,
                        'sender_id' => $sender,
                        'receiver_id' => $receiverId,
                        'organization_id' => $user->organizations[0]["id"],
                    ]);

                    $mediaFiles[] = $media;
                }
                return response()->json([
                    'message' => 'Files uploaded successfully',
                    'media' => $mediaFiles
                ], 200);
            }
            $filename = time() . '-' . $request->file('files')->getClientOriginalName();
            $fileurl = $this->uploadImage($request->file('files'));
            $filePath = $fileurl;

            $media = OrganizationTwoPersonMedia::create([
                'filename' => $filename,
                'file_path' => $filePath,
                'sender_id' => $sender,
                'receiver_id' => $receiverId,
                'organization_id' => $user->organizations[0]["id"],

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

    // public function getAllMediaByOrganization($organizationId)
    // {
    //     $media = OrganizationTwoPersonMedia::where('organization_id', $organizationId)->get();

    //     if ($media->isEmpty()) {
    //         return response()->json([
    //             'message' => 'No media found for the specified organization',
    //             'status' => 'false'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'message' => 'Media retrieved successfully',
    //         'media' => $media
    //     ], 200);
    // }

    public function getAllMediaByOrgGroup($groupId)
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

    public function getAllMediaForTwoPersons($receiverId)
    {
        $user = User::where('id', $receiverId)->first();
        $organizationId = $user->organizations[0]["id"];
        $senderId = auth()->id();
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

    public function getMediaByReceiver($receiverId)
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

    public function getAllMediaByGroup($groupId){

        if($groupId == null){
            return response()->json([
                'message' => 'Group id is required',
                'status' => 'false'
            ], 400);
        }

        return response()->json([
            'message' => 'Media retrieved successfully',
        ]);
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
