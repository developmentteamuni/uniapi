<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use App\Models\Reaction;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    public function index() 
    {
        $feeds = Feed::with('user')->withCount('reactions')->get();
        return response([
            'feeds' => $feeds
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'body' => 'required|max:225'
        ]);

        $datatosave = [
            'body' => $request->body
        ];

        $image = $request->file('image');
        $imageName = date('YmHdi').$image->getClientOriginalName();
        $image->move(public_path('public/feedImages'), $imageName);
        $datatosave['image'] = $imageName;

        $feed = auth()->user()->feeds()->create($datatosave);
        if(!$feed)
            return response([
                'message' => 'Error posting data'
            ], 500);

        return response([
            'message' => 'success',
            'post' => $feed
        ], 201);
    }

    public function react($feed_id)
    {
        $reaction = Reaction::where([['feed_id', $feed_id], ['user_id', auth()->id()]])->first();

        if(!empty($reaction)) {
            $reaction->delete();
            return response([
                'message' => 'Unliked'
            ], 200);
        }else{
            Reaction::create([
                'feed_id' => $feed_id,
                'user_id' => auth()->id()
            ]);
            return response([
                'message' => 'Liked'
            ], 200);
        }

        return response([
            'message' => 'Error liking feed'
        ], 500);
    }
}
