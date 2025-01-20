<x-app-layout>
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
                <option value="inativo" {{ old('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
            @error('status')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none">
                Salvar
            </button>
        </div>
    </form>
</x-app-layout>
