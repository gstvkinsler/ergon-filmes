<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store (PostRequest $request)
    {
        $validations = $request->validated();

        try {
            $post = $this->postService->register($validations);
            return $this->index($request);
        } catch (\Throwable $e) {
            return view('error');
        }
    }

    public function index(Request $request)
    {
        $query = Post::select('posts.*', 'votes.recommends', 'post_followers.id as is_following')
            ->leftJoin('votes', function ($join) {
                $join->on('votes.post_id', '=', 'posts.id')
                    ->where('votes.user_id', Auth::user()->id);
            })
            ->leftJoin('post_followers', function ($join) {
                $join->on('post_followers.post_id', '=', 'posts.id')
                    ->where('post_followers.user_id', Auth::user()->id);
            })
            ->orderBy('posts.id');

        if ($request->input('tab') === 'followed') {
            $query->whereNotNull('post_followers.id');
        }

        $posts = $query->get();

        return view('feed', compact('posts'));
    }

    public function create()
    {
        return view('feed-form');
    }


    public function show(Post $id){
        return response()->json([
            'status' => true,
            'id' => $id,
            ], 200);
    }

    public function update(PostRequest $request, string $id) : JsonResponse
    {
        $validations = $request->validated();

        $post = $this->postService->updatePost($validations, $id);
        try{
            return response()->json([
                'status' => true,
                'message' => "Post editado com sucesso!",
                'post' => $post
            ], 201);
        } catch(\Throwable $e){
            return response()->json([
                'status' => true,
                'message' => "Post não editado!",
                'post' => $post,
            ], 400);
        }
    }
}
