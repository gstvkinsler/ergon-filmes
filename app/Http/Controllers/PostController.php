<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\PostService;
use App\Http\Requests\PostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('feed')->with('success', 'Postagem criada com sucesso!');
        } catch (\Throwable $e) {
            return view('error');
        }
    }

    public function index(Request $request)
    {
        $query = Post::select('posts.id', 'posts.user_id', 'posts.title', 'posts.description', 'posts.category', 'votes.recommends', 'post_followers.id as is_following', DB::raw('count(all_pf.id) as total_pfs'))
            ->leftJoin('votes', function ($join) {
                $join->on('votes.post_id', '=', 'posts.id')
                    ->where('votes.user_id', Auth::user()->id);
            })
            ->leftJoin('post_followers', function ($join) {
                $join->on('post_followers.post_id', '=', 'posts.id')
                    ->where('post_followers.user_id', Auth::user()->id);
            })
            ->where('posts.status', 'ativo')
            ->leftJoin('post_followers as all_pf', 'all_pf.post_id', 'posts.id')
            ->groupBy('posts.id', 'votes.id', 'posts.user_id', 'posts.title', 'posts.description', 'posts.category', 'votes.recommends', 'post_followers.id')
            ->orderByDesc('posts.id');

        if ($request->input('tab') === 'followed') {
            $query->whereNotNull('post_followers.id');
        }

        $posts = $query->get();

        return view('feed', compact('posts'));
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

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Você não tem permissão para deletar este post.');
        }

        $post->delete();

        return redirect()->route('feed')->with('success', 'Post deletado com sucesso!');
    }

    public function conclude(Post $post)
    {

        if ($post->user_id === Auth::id()) {
            $post->status = 'concluido';
            $post->save();
        }

        return redirect()->route('feed')->with('success', 'Postagem concluída!');
    }

}
