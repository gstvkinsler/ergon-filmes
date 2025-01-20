<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class=" flex justify-center py-6 w-full ">
        <div class="container-wrap w-3/5">
            <!-- Abas -->
            <ul class="nav nav-tabs mb-4" id="feedTabs" role="tablist" style="border-bottom:2px solid #4F46E5 !important;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" style="color:#4F46E5 !important;" id="all-posts-tab" data-bs-toggle="tab" data-bs-target="#all-posts" type="button" role="tab" aria-controls="all-posts" aria-selected="true">
                        Todos os Posts
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="followed-posts-tab" style="color:#4F46E5 !important;" data-bs-toggle="tab" data-bs-target="#followed-posts" type="button" role="tab" aria-controls="followed-posts" aria-selected="false">
                        Seguindo
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="feedTabsContent">
                <div class="tab-pane fade show active" id="all-posts" role="tabpanel" aria-labelledby="all-posts-tab">
                    @forelse ($posts as $post)
                    <div class="w-full  p-6 rounded-lg shadow-md mt-2 " style="background-color: #1F2937">
                        <div class="space-y-4" >
                            <div class="feed-item text-gray-200">
                                <div class="wrapper w-full  justify-between " style="border-radius: 8px">
                                    <div class="wrapper-flex-box flex justify-between" >
                                        <div class="teste">
                                            <h3 class="feed-titulo ml-1">{{ $post['title'] }}</h3>
                                        </div>
                                        <div class="teste ">
                                            <span class="text-center flex" style="border:1px solid blue; border-radius: 12px">
                                                <small class="feed-categoria ml-2 mr-2" style="color:blue;">{{ $post['category'] }}</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="teste ">
                                        <p class="feed-descricao ml-1">Descrição: {{ $post['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-actions flex justify-between items-center  mt-2">
                            <div class="follow-btn-wrapper h-6 text-sky-500 flex items-center justify-center" style="border: 2px solid #0EA5E9; border-radius: 20px;">
                                <form method="POST" action="{{ route('follow.store') }}">
                                    @csrf
                                    <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                    <span>
                                    @if($post->is_following)
                                    <button class="flex items-center text-center text-green-300 font-semibold" style="padding-bottom: 2px;">
                                        <div class="wrapper mr-4 ml-4">
                                            </i>Seguindo
                                        </div>
                                    </button>
                                    @else
                                    <button class="flex items-center text-center text-sky-500 font-semibold" style="padding-bottom: 2px;">
                                        <div class="wrapper mr-4 ml-4">
                                            </i>Seguir
                                        </div>
                                    </button>
                                    @endif
                                    </span>
                                </form>
                            </div>
                            <div class="recommends-container flex justify-between mt-2">
                                <form method="POST" action="{{ route('votes.store') }}">
                                    @csrf
                                    <input type="hidden" value="yes" name="recommends"></input>
                                    <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                    <div class="like-button text-green-500">
                                        <button>
                                            @if($post->recommends == 'yes')
                                            <i class="bi bi-hand-thumbs-up-fill"></i>
                                            @else
                                            <i class="bi bi-hand-thumbs-up"></i>
                                            @endif
                                        </button>
                                    </div>
                                </form>
                                <div class="dislike-button ml-2 text-red-500 ">
                                    <form method="POST" action="{{ route('votes.store') }}">
                                        @csrf
                                        <input type="hidden" value="no" name="recommends"></input>
                                        <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                        <button>
                                            @if($post->recommends == 'no')
                                            <i class="bi bi-hand-thumbs-down-fill"></i>
                                            @else
                                            <i class="bi bi-hand-thumbs-down"></i>
                                            @endif
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p>Não há postagens no momento.</p>
                    @endforelse
                </div>

                <!-- Posts Seguindo -->
                <div class="tab-pane fade" id="followed-posts" role="tabpanel" aria-labelledby="followed-posts-tab">
                    @forelse ($posts as $post)
                        @if (!is_null($post->is_following)) <!-- Verifica se o post está sendo seguido -->
                            <div class="w-full p-6 rounded-lg shadow-md mt-2" style="background-color: #1F2937">
                                <div class="space-y-4">
                                    <div class="feed-item text-gray-200">
                                        <div class="wrapper w-full justify-between" style="border-radius: 8px">
                                            <div class="wrapper-flex-box flex justify-between">
                                                <div class="teste">
                                                    <h3 class="feed-titulo ml-1">{{ $post['title'] }}</h3>
                                                </div>
                                                <div class="teste">
                                                    <span class="text-center flex" style="border:1px solid blue; border-radius: 12px">
                                                        <small class="feed-categoria ml-2 mr-2" style="color:blue;">{{ $post['category'] }}</small>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="teste">
                                                <p class="feed-descricao ml-1">Descrição: {{ $post['description'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botões de recomendação e seguir, se necessário -->
                                <div class="container-actions flex justify-between items-center  mt-2">
                                <div class="follow-btn-wrapper h-6 text-sky-500 flex items-center justify-center" style="border: 2px solid #0EA5E9; border-radius: 20px;">
                                    <form method="POST" action="{{ route('follow.store') }}">
                                        @csrf
                                        <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                        <span>
                                        @if($post->is_following)
                                        <button class="flex items-center text-center text-green-300 font-semibold" style="padding-bottom: 2px;">
                                            <div class="wrapper mr-4 ml-4">
                                                </i>Seguindo
                                            </div>
                                        </button>
                                        @else
                                        <button class="flex items-center text-center text-sky-300 font-semibold" style="padding-bottom: 2px;">
                                            <div class="wrapper mr-4 ml-4">
                                                </i>Seguir
                                            </div>
                                        </button>
                                        @endif
                                        </span>
                                    </form>
                                </div>
                                <div class="recommends-container flex justify-between mt-2">
                                    <form method="POST" action="{{ route('votes.store') }}">
                                        @csrf
                                        <input type="hidden" value="yes" name="recommends"></input>
                                        <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                        <div class="like-button text-green-500">
                                            <button>
                                                @if($post->recommends == 'yes')
                                                <i class="bi bi-hand-thumbs-up-fill"></i>
                                                @else
                                                <i class="bi bi-hand-thumbs-up"></i>
                                                @endif
                                            </button>
                                        </div>
                                    </form>
                                    <div class="dislike-button ml-2 text-red-500 ">
                                        <form method="POST" action="{{ route('votes.store') }}">
                                            @csrf
                                            <input type="hidden" value="no" name="recommends"></input>
                                            <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                            <button>
                                                @if($post->recommends == 'no')
                                                <i class="bi bi-hand-thumbs-down-fill"></i>
                                                @else
                                                <i class="bi bi-hand-thumbs-down"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>Não há posts seguidos no momento.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
