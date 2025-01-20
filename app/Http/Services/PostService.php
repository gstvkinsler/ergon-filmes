<?php

// app/Services/UserService.php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function register(array $data) : Post
    {
        $user = Auth::user();

        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'category' => $data['category'],
            'status' =>$data['status'],
            'user_id' => $user->id,
        ]);

        return $post;
    }

    public function updatePost(array $data, string $id) : Post
    {
        $post = Post::findOrFail($id);
        $post->title = $data['title'];
        $post->description = $data['description'];
        $post->category = $data['category'];
        $post->save();

        return $post;
    }
}
