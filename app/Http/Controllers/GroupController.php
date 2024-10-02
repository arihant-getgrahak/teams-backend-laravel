<?php

namespace App\Http\Controllers;
use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupAddUserRequest;
use App\Http\Requests\GroupChatRequest;
use App\Http\Requests\GroupChatUpdateRequest;
use App\Models\Group;
use App\Models\GroupMessage;
use DB;
use App\Transformers\GroupDisplayTransform;
use Cache;

class GroupController extends Controller
{
    public function create(GroupCreateRequest $request)
    {
        $data = [
            "name" => $request->name,
            "created_by" => auth()->user()->id,
        ];
        $group = Group::create($data);

        Cache::put("group_{$group->id}", $group);


        return response()->json([
            "message" => __('auth.created', ['attribute' => 'Group']),
            "data" => $group
        ], 200);
    }

    public function displayGroup()
    {
        $group = Cache::remember('groups', 60, function () {
            return Group::with(['createdBy:id,name', "users:id,name"])->get();

        });
        $group = [$group];
        $response = fractal($group, new GroupDisplayTransform())->toArray();
        return response()->json([
            "status" => true,
            "message" => __("auth.fetched", ["attribute" => "Group"]),
            "data" => $response["data"][0]["data"]
            // "Data" => $group
        ], 200);
    }

    public function addUser(GroupAddUserRequest $request)
    {
        // Add user to group
        $group = Group::find($request->group_id);

        if ($group->users()->find($request->user_id)) {
            return response()->json([
                "message" => __('auth.added', ['attribute' => 'User']),
                "status" => false
            ], 500);
        }
        $group->users()->attach($request->user_id);

        return response()->json([
            "status" => true,
            "message" => __('auth.add', ['attribute' => 'User']),
            "data" => $group
        ], 200);
    }

    public function deleteGroup(string $lan, $group_id)
    {
        $group = Group::find($group_id);
        if (!$group) {
            return response()->json([
                "status" => false,
                "message" => __('auth.notfound', ['attribute' => 'Group']),
            ], 500);
        }
        $group->delete();

        Cache::forget("groups");
        Cache::forget("group_{$group_id}");
        Cache::forget("group_messages_{$group_id}");

        return response()->json([
            'status' => true,
            'message' => __('auth.deleted', ['attribute' => 'Group']),
        ], 200);
    }


    public function addMessage(GroupChatRequest $request)
    {
        DB::beginTransaction();
        try {
            // dd($request->all());
            $data = GroupMessage::create($request->all());

            DB::commit();
            return response()->json([
                "status" => true,
                "message" => __('auth.sent', ['attribute' => 'Message']),
                "data" => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function getGroupMessages(string $lan, $group_id)
    {
        $group = Group::find($group_id);
        if (!$group) {
            return response()->json([
                "status" => false,
                "message" => __('auth.notfound', ['attribute' => 'Group']),
            ], 500);
        }

        $message = GroupMessage::where("group_id", $group_id)
            ->with('user:id,name')
            ->paginate(20);

        return response()->json([
            'status' => true,
            'message' => __('auth.fetched', ['attribute' => 'GroupMessage']),
            'data' => $message,
        ], 200);
    }
    public function updateMessage(GroupChatUpdateRequest $request, string $lan, $message_id)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($request->group_id);
            if (!$group) {
                return response()->json([
                    "status" => false,
                    "message" => __('auth.notfound', ['attribute' => 'Group']),
                ], 500);
            }
            $message = GroupMessage::find($message_id);
            if (!$message) {
                return response()->json([
                    "status" => false,
                    "message" => __('auth.notfound', ['attribute' => 'Message']),
                ], 500);
            }

            if ($message->isUpdate) {
                return response()->json([
                    "status" => false,
                    "message" => __('auth.once'),
                ], 500);
            }

            // update group chat message

            $message->update(["message" => $request->message, "updatedAt" => now(), "isUpdate" => true]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => __('auth.updated', ['attribute' => 'Message']),
                'data' => $message
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function deleteMessage(string $lan, $group_id, $message_id)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($group_id);
            if (!$group) {
                return response()->json([
                    "status" => false,
                    "message" => __("auth.notfound", ["attribute" => "Group"]),
                ], 500);
            }
            $message = GroupMessage::find($message_id);
            if (!$message) {
                return response()->json([
                    "status" => false,
                    "message" => __("auth.notfound", ["attribute" => "Message"]),
                ], 500);
            }
            if ($message->isDelete) {
                return response()->json([
                    "status" => false,
                    "message" => __('auth.alreadydeleted', ['attribute' => 'Message']),
                ], 500);
            }
            $message->update(["message" => "This Message has been deleted", "isDelete" => true, "deletedAt" => now()]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => __('auth.deleted', ['attribute' => 'Message']),
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function display(string $lan, string $id)
    {
        $group = Group::find($id);
        if (!$group) {
            return response()->json([
                "status" => false,
                "message" => __('auth.notfound', ['attribute' => 'Group']),
            ], 500);
        }
        $group = [$group];
        $response = fractal($group, new GroupDisplayTransform())->toArray();
        return response()->json([
            "status" => true,
            "message" => __("auth.fetched", ["attribute" => "Group"]),
            "data" => $response["data"][0]["data"]
            // "Data" => $group
        ], 200);
    }
}

