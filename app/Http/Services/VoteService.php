<?php

// app/Services/UserService.php

namespace App\Http\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\PostFollower;
use App\Models\Post;
use App\Models\Vote;

class VoteService
{
    public function register(array $data)
    {
        $user = Auth::user();

        $post = Post::find($data['post_id']);
        if (!$post) {
            return [
                'status' => false,
                'message' => 'Post não encontrado!',
            ];
        }
        $existingVote = Vote::where('post_id', $post->id)->where('user_id', $user->id)->first();
        if ($existingVote){
            $recommended = $existingVote->recommends ==  $data['recommends'] ? null : $data['recommends'];
            $existingVote->recommends = $recommended;
            $existingVote->save();

            return [
                'status' => true,
                'message' => 'Voto atualizado com sucesso!',
                'vote' => $existingVote
            ];
        }

        $postFollower = PostFollower::where('user_id', $user->id)->where('post_id', $post->id)->first();

        if(!$postFollower){
            PostFollower::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        };

        $vote = Vote::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'recommends' => $data['recommends']
        ]);

        return ['status' => true];
    }
}
