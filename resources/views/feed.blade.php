<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-gray-200 leading-tight">
        </h2>
    </x-slot>

    <div class=" flex justify-center py-6 w-full ">
        <div class="container-wrap w-3/5">
            <!-- Abas -->
            <ul class="nav nav-tabs mb-4 flex justify-between" id="feedTabs" role="tablist" style="border-bottom:2px solid #4F46E5 !important;">
                <div class="wrapper flex">
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
                </div>
                <div class="btn">
                    <button id="openModalButton" class="btn btn-primary w-5 h-5 flex justify-center items-center mt-2" style="background-color: #4F46E5;">
                        <p class="text-center">+</p>
                    </button>
                </div>
            </ul>

            <div class="tab-content" id="feedTabsContent">
                <div class="tab-pane fade show active" id="all-posts" role="tabpanel" aria-labelledby="all-posts-tab">
                    @if (session('success'))
                        <div id="alertSuccess" class="alert alert-success bg-green-500 text-white p-4 rounded shadow-lg mb-4">
                            <strong>Sucesso!</strong> {{ session('success') }}
                        </div>

                        <script>
                            setTimeout(function () {
                                document.getElementById('alertSuccess').style.display = 'none';
                            }, 3000);
                        </script>
                    @endif
                    @if (session('error'))
                        <div id="alertError" class="alert alert-error bg-red-500 text-white p-4 rounded shadow-lg mb-4">
                            <strong>Erro!</strong> {{ session('error') }}
                        </div>

                        <script>
                            setTimeout(function () {
                                document.getElementById('alertError').style.display = 'none';
                            }, 3000);
                        </script>
                    @endif
                    @forelse ($posts as $post)
                    <div class="w-full  p-6 rounded-lg shadow-md mt-2 " style="background-color: #1F2937">
                        <div class="space-y-4" >
                            <div class="feed-item text-gray-200">
                                <div class="wrapper w-full  justify-between " style="border-radius: 8px">
                                    <div class="wrapper-flex-box flex justify-between" >
                                        <div class="teste">
                                            <h1 class="feed-titulo ml-1">{{ $post['title'] }}</h1>
                                        </div>
                                        <div class="teste ">
                                            <span class="text-center flex" style="border:1px solid blue; border-radius: 12px">
                                                <small class="feed-categoria ml-2 mr-2" style="color:blue;">{{ $post['category'] }}</small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="teste mt-2">
                                        <p class="feed-descricao ml-1">Descrição: {{ $post['description'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-actions flex justify-between items-center  mt-2">
                            <div class="wrapper flex">
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
                            <span>
                                @if($post->user_id === Auth::id() && $post->total_pfs == 0)
                                <div class="delete-btn-wrapper h-6 text-red-500 flex items-center justify-center mt-1">
                                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Você tem certeza que deseja deletar este post?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                        <button type="submit" class="text-red-500 p-2"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                                @endif
                            </span>
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
                        @if (!is_null($post->is_following))
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
                                <div class="container-actions flex justify-between items-center  mt-2">
                                    <div class="wrapper flex">
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
                                        <span>
                                            @if($post->user_id === Auth::id())
                                            <div class="delete-btn-wrapper h-6 text-red-500 flex items-center justify-center mt-1" >
                                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Você tem certeza que deseja deletar este post?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" value="{{ $post['id'] }}" name="post_id"></input>
                                                    <button type="submit" class="text-red-500 p-2"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                            @endif
                                        </span>
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
                <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
                    <form action="{{ route('posts.store') }}" method="POST" class="w-full max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-bold mb-2">Título</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Digite o título"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                            @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Descrição</label>
                            <textarea id="description" name="description" placeholder="Digite a descrição"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 font-bold mb-2">Categoria</label>
                            <select id="category" name="category"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category') border-red-500 @enderror">
                                <option value="">Selecione uma categoria</option>
                                <option value="filme">filme</option>
                                <option value="serie">serie</option>
                            </select>
                            @error('category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 font-bold mb-2">Status</label>
                            <select id="status" name="status"
                                class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                                <option value="">Selecione o status</option>
                                <option value="ativo" {{ old('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="concluido" {{ old('status') == 'concluido' ? 'selected' : '' }}>Concluido</option>
                            </select>
                            @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none mr-2">
                                Cancelar
                            </button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const modal = document.getElementById('modal');

    openModalButton.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    closeModalButton.addEventListener('click', () => {
        modal.classList.add('hidden');
    });
</script>
</x-app-layout>
