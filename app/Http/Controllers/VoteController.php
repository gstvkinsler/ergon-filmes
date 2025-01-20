<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class VoteController extends Controller
{
    protected $voteService;

    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    public function store(Request $request)
    {
        $response = $this->voteService->register($request->all());

        if($response['status'] === false){
            return view('error');
        }
        return redirect()->intended(route('feed', absolute: false));
    }
}

