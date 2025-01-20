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

    public function destroy($id)
    {
        $response = $this->postFollowerService->unfollowPost($id);

        if($response['status'] === false){
            return view('error');
        }

        return redirect()->intended(route('feed', absolute: false));
    }
}
