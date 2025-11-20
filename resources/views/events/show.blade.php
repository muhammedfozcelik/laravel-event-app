<!DOCTYPE html>
<html lang="tr">

<head>
    <title>{{ $event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
            <div class="flex justify-between items-center mb-4">
                <span
                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $event->category->name }}</span>
                <span class="text-gray-500 text-sm">{{ $event->event_date }}</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>

            <div class="prose max-w-none text-gray-700 mb-8">
                {{ $event->description }}
            </div>

            <div class="border-t pt-6 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Organizatör: <span class="font-bold">{{ $event->user->name }}</span>
                </div>
                <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800">← Listeye Dön</a>
            </div>
        </div>
    </div>
</body>

</html>
