<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileController;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Reaction;
use App\Models\SavedFeed;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    public function index()
    {
        $feeds = Feed::with('user')->with('user.profile')->get();
        return response([
            'feed' => ProfileController::collection($feeds),
        ]);
    }

    public function following()
    {
        $feeds = Feed::join('friends', 'feeds.user_id', '=', 'friends.follower_id')
            ->with('user.follower.user')
            ->where('friends.user_id', auth()->id())
            ->latest('friends.created_at')->get();
        return response([
            'feed' => $feeds,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|max:225'
        ]);

        $datatosave = [
            'body' => $request->body
        ];


        $image = $request->file('image');
        if (!empty($image)) {
            $request->validate([
                'image' => 'image',
            ]);

            $imageName = date('YmHdi') . $image->getClientOriginalName();
            $image->move(public_path('public/feedImages'), $imageName);
            $datatosave['image'] = $imageName;
        }
        $feed = auth()->user()->feeds()->create($datatosave);
        if (!$feed)
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

        if (!empty($reaction)) {
            $reaction->delete();
            return response([
                'message' => 'Unliked'
            ], 200);
        } else {
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

    public function comments($feed_id)
    {
        $comments = Comment::with('user.profile')->where('feed_id', $feed_id)->latest()->get();
        if ($comments)
            return response([
                'comments' => $comments
            ], 200);

        return response([
            'message' => 'Something went wrong'
        ], 500);
    }

    public function makeComment(Request $request, $feed_id)
    {
        $user_id = auth()->id();
        $request->validate([
            'body' => 'required|max:200'
        ]);

        $comment = Comment::create([
            'user_id' => $user_id,
            'feed_id' => $feed_id,
            'body' => $request->body
        ]);

        if ($comment)
            return response([
                'message' => 'Commented'
            ], 201);

        return response([
            'message' => 'Error posting comment'
        ], 500);
    }

    public function saveFeed($feed_id)
    {
        $saved = SavedFeed::create([
            'user_id' => auth()->id(),
            'feed_id' => $feed_id
        ]);

        if ($saved)
            return response([
                'message' => 'Saved'
            ],  201);

        return response([
            'message' => 'Error saving post'
        ], 500);
    }

    public function getSavedFeeds()
    {
        $savedFeeds = SavedFeed::with('feed.user:id,firstname,lastname')->where('user_id', auth()->id())->latest()->get();

        if ($savedFeeds)
            return response([
                'savedfeeds' => $savedFeeds
            ], 200);

        return response([
            'message' => 'Error fetching saved feeds'
        ], 500);
    }


    public function deleteFeed(Feed $feed)
    {
        $feed->delete();

        return response([
            'message' => 'Deleted'
        ], 200);
    }

    public function checkLike($user_id, $feed_id)
    {
        $check = Feed::where('user_id', $user_id)->where('id', $feed_id)->first();
        if ($check) {
            return response([
                'message' => 'Liked'
            ], 200);
        } else {
            return response([
                'message' => 'Not liked'
            ], 200);
        }
    }
}
