<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Library
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($items->isEmpty())
                <div class="p-4 bg-white shadow rounded">
                    <p>Your library is empty.</p>
                </div>
            @endif

            @foreach($items as $item)
                <div class="mb-4 p-4 bg-white shadow rounded">
                    <h3 class="text-lg font-bold">
                        {{ $item->mediaItem->title }}
                    </h3>

                    <p class="text-gray-600">
                        {{ $item->mediaItem->type }}
                    </p>

                    <p>
                        <strong>Status:</strong> {{ $item->status }}
                    </p>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>