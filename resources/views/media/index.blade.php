<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Media List
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($mediaItems as $item)
                <div class="mb-6 p-4 bg-white shadow rounded">

                    <h3 class="text-lg font-bold">{{ $item->title }}</h3>
                    <p class="text-gray-600">{{ $item->type }}</p>
                    <p class="mt-2">{{ $item->description }}</p>

                    <form method="POST" action="/media/{{ $item->id }}/planned" class="mt-3">
                        @csrf
                        <button class="px-4 py-2 bg-blue-500 text-white rounded">
                            Add to Planned
                        </button>
                    </form>

                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>