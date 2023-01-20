<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupStoreRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Models\GroupImage;
use App\Models\GroupPost;
use App\Models\JoinGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function index()
    {
        $groups = Group::latest()->get();

        return response([
            'groups' => GroupResource::collection($groups)
        ], 200);
    }

    public function myGroup()
    {
        $groups = Group::whereUserId(auth()->id())->latest()->get();

        return response(
            [
                'groups' => GroupResource::collection($groups)
            ],
            200
        );
    }

    public function joinGroup($group_id)
    {
        $group_owner = Group::whereId($group_id)->pluck('user_id');
        $cleaned = str_replace(array('[', ']'), '', $group_owner);

        $join = JoinGroup::create([
            'group_id' => $group_id,
            'joiner_id' => auth()->id(),
            'group_owner' => (int) $cleaned
        ]);

        if ($join) {
            return response([
                'message' => 'success',
            ], 200);
        } else {
            return response([
                'message' => 'Error joining group',
            ], 500);
        }
    }

    public function store(GroupStoreRequest $groupStoreRequest)
    {
        $groupStoreRequest->validated();

        $dataToSave = [
            'user_id' => auth()->id(),
            'group_name' => $groupStoreRequest->group_name,
            'group_type' => $groupStoreRequest->group_type,
            'requirements' => $groupStoreRequest->requirements,
            'link' => $groupStoreRequest->link,
            'entrace' => $groupStoreRequest->entrace,
            'describe' => $groupStoreRequest->describe,
            'description' => $groupStoreRequest->description,
            'attendance' => $groupStoreRequest->attendance,
            'fee' => $groupStoreRequest->fee,
        ];

        $gp = Group::create($dataToSave);

        if ($gp) {

            if ($groupStoreRequest->hasFile('image')) {
                foreach ($groupStoreRequest->file('image') as $image) {

                    $imageName =
                        $image->getClientOriginalName();
                    $image->move(public_path('public/GroupImages'), $imageName);
                    $imageDB = new GroupImage();
                    $imageDB->group_id = $gp->id;
                    $imageDB->image = $imageName;
                    $saveImage = $imageDB->save();
                }
                if ($saveImage) {
                    return response([
                        'message' => 'success',
                    ], 201);
                } else {
                    return response([
                        'message' => 'error',
                    ], 400);
                }
            } else {
                return response([
                    'message' => 'Two or more image needed',
                ], 400);
            }
        } else {
            return response([
                'message' => 'Error creating room',
            ], 400);
        }
    }

    public function checkIfInGroup($group_id)
    {
        $check = JoinGroup::where('group_id', $group_id)->where('joiner_id', auth()->id())->first();
        if ($check) {
            return response([
                'message' => 'success'
            ], 200);
        } else {
            return response([
                'message' => 'error'
            ], 500);
        }
    }

    public function createGroupPost(Request $request)
    {
        $request->validate([
            'body' => 'required|max:225',
            'group_id' => 'required'
        ]);

        $datatosave = [
            'user_id' => auth()->id(),
            'group_id' => $request->group_id,
            'body' => $request->body
        ];


        $image = $request->file('image');
        if (!empty($image)) {
            $request->validate([
                'image' => 'image',
            ]);

            $imageName = date('YmHdi') . $image->getClientOriginalName();
            $image->move(public_path('public/groupFeedImages'), $imageName);
            $datatosave['image'] = $imageName;
        }
        $feed = GroupPost::create($datatosave);
        if (!$feed)
            return response([
                'message' => 'Error posting data'
            ], 500);

        return response([
            'message' => 'success',
            'post' => $feed
        ], 201);
    }

    public function fetchGroupPost($group_id)
    {
        $posts = GroupPost::with('user')->latest()->get();

        return response([
            'post' => $posts
        ], 200);
    }
}
