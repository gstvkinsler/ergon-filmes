<?php

namespace App\Http\Controllers;

use App\Http\Services\PostFollowerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class PostFollowerController extends Controller
{
    protected $postFollowerService;

    public function __construct(PostFollowerService $postFollowerService)
    {
        $this->postFollowerService = $postFollowerService;
    }

    public function store(Request $request)
    {
        $response = $this->postFollowerService->followPost($request->all());

        if($response['status'] === false){
            return view('error');
        }

        return redirect()->intended(route('feed', absolute: false));
    }

    public function unfollow($id) : JsonResponse
    {
        $response = $this->postFollowerService->unfollowPost($id);

        if (!$response) {
            return response()->json([
                "status" => false,
                "message" => "Postagem não encontrada!"
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Você deixou de seguir esta postagem!"
        ], 200);
    }
}
