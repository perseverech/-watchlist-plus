<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Library
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($items->isEmpty())
                <div class="p-4 bg-white shadow rounded">
                    <p>Your library is empty.</p>
                </div>
            @endif

            @foreach($items as $item)
                <div class="mb-4 p-4 bg-white shadow rounded">
                    <h3 class="text-lg font-bold">{{ $item->mediaItem->title }}</h3>
                    <p class="text-gray-600">{{ $item->mediaItem->type }}</p>
                    <p><strong>Status:</strong> {{ $item->status }}</p>

                    <form method="POST" action="{{ route('library.destroy', $item->id) }}" style="margin-top: 12px;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" style="background-color: #dc2626; color: white; padding: 8px 16px; border-radius: 6px;">
                            Remove
                        </button>
                    </form>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>