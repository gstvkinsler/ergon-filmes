<?php

// app/Services/UserService.php

namespace App\Http\Services;

use App\Models\Post;
use App\Models\PostFollower;
use Illuminate\Support\Facades\Auth;

class PostFollowerService
{
    public function followPost( $data)
    {
        $user = Auth::user();

        $post = Post::find($data['post_id']);
        if(!$post) {
            return [
                'status' => false,
                'message' => 'Post não encontrado!',
            ];
        };
        $existingFollower = PostFollower::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if ($existingFollower){
            $existingFollower->delete();

            return [
                'status' => true,
                'message' => 'Você deixou de seguir essa postagem',
                'vote' => $existingFollower
            ];
        }

        if(!$post) {
            return false;
        };

        $follower = PostFollower::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return [
            'status' => true,
            'message' => 'Você começou a seguir esta postagem.',
            'follower' => $follower,
        ];
    }

    public function unfollowPost(string $data) : Bool
    {
        $user = Auth::user();

        $follower = PostFollower::where('user_id', $user->id)->where('post_id', $data)->first();

        if($follower == null){
            return false;
        };

        $follower->delete();

        return true;
    }
}
