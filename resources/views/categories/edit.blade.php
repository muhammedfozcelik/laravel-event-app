<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategoriyi Düzenle: {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Kategori Adı</label>
                        <input type="text" name="name" value="{{ $category->name }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <a href="{{ route('events.index') }}"
                            class="text-gray-500 hover:text-gray-700 text-sm">İptal</a>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
