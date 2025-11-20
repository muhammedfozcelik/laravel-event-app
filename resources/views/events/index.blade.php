<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etkinlik Yönetimi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('events.index') }}" class="text-xl font-bold text-indigo-600">EventApp</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-600 text-sm">Merhaba, {{ Auth::user()->name }}</span>
                        <div class="flex space-x-2">
                            <a href="{{ route('categories.create') }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">Kategori
                                Ekle +</a>
                            <a href="{{ route('events.create') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Etkinlik
                                Oluştur</a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">Çıkış Yap</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">Giriş Yap</a>
                        <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600">Kaydol</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="md:col-span-1">
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4 border-b pb-2">Kategoriler</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('events.index') }}"
                            class="block text-gray-600 hover:text-indigo-600 {{ request()->routeIs('events.index') ? 'font-bold text-indigo-600' : '' }}">
                            Tüm Etkinlikler
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li class="flex justify-between items-center group hover:bg-gray-50 p-1 rounded">
                            <a href="{{ route('events.category', $cat->slug) }}"
                                class="block text-gray-600 hover:text-indigo-600 flex-grow {{ request()->is('categories/' . $cat->slug) ? 'font-bold text-indigo-600' : '' }}">
                                {{ $cat->name }}
                            </a>

                            @auth
                                <div class="hidden group-hover:flex items-center space-x-2 pl-2">
                                    <a href="{{ route('categories.edit', $cat) }}"
                                        class="text-blue-400 hover:text-blue-600" title="Düzenle">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                                        onsubmit="return confirm('BU KATEGORİYİ SİLMEK İSTEDİĞİNE EMİN MİSİN? \nBuna bağlı TÜM etkinlikler de silinecektir!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600" title="Sil">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @endauth
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="md:col-span-3">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <h2 class="text-2xl font-bold mb-6 text-gray-800">
                {{ isset($category) ? $category->name . ' Etkinlikleri' : 'Güncel Etkinlikler' }}
            </h2>

            @if ($events->count() > 0)
                <div class="grid gap-6">
                    @foreach ($events as $event)
                        <div
                            class="bg-white p-6 rounded-lg shadow hover:shadow-md transition duration-300 border-l-4 border-indigo-500">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span
                                        class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-indigo-600 bg-indigo-200 last:mr-0 mr-1 mb-2">
                                        {{ $event->category->name }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        <a href="{{ route('events.show', $event) }}"
                                            class="hover:underline">{{ $event->title }}</a>
                                    </h3>
                                    <p class="text-gray-600 mb-4 line-clamp-2">
                                        {{ Str::limit($event->description, 150) }}</p>
                                    <div class="text-sm text-gray-500 flex items-center gap-4">
                                        <span>📅 {{ $event->event_date }}</span> <span>👤
                                            {{ $event->user->name }}</span>
                                    </div>
                                </div>

                                @if (auth()->id() === $event->user_id)
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('events.edit', $event) }}"
                                            class="text-yellow-600 hover:text-yellow-800 text-sm font-semibold text-right">Düzenle</a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST"
                                            onsubmit="return confirm('Silmek istediğine emin misin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-800 text-sm font-semibold">Sil</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-50 p-4 rounded-md text-yellow-700">
                    Bu kategoride henüz etkinlik bulunmuyor.
                </div>
            @endif
        </div>
    </div>
</body>

</html>
