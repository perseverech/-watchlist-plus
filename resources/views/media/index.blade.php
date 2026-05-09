<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            WatchList+ Media
        </h2>
    </x-slot>

    <div style="background-color: #1f1f1f; min-height: 100vh; padding: 32px;">
        <div style="max-width: 1000px; margin: 0 auto;">

            @if(session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <h1 style="color: white; font-size: 28px; margin-bottom: 24px;">
                Movies and TV Series
            </h1>

            @foreach($mediaItems as $item)
                <div style="display: flex; gap: 24px; background-color: #2a2a2a; padding: 20px; border-radius: 10px; margin-bottom: 20px; color: white;">

                    <div style="width: 120px; height: 170px; background-color: #444; display: flex; align-items: center; justify-content: center; color: #aaa; border-radius: 6px;">
                        Poster
                    </div>

                    <div style="flex: 1;">
                        <h2 style="font-size: 24px; margin-bottom: 6px;">
                            {{ $item->title }}
                        </h2>

                        <p style="color: #9ca3af; margin-bottom: 8px;">
                            {{ ucfirst($item->type) }}
                        </p>

                        <p style="color: #d1d5db; margin-bottom: 16px;">
                            {{ $item->description }}
                        </p>

                        <form method="POST" action="/media/{{ $item->id }}/planned">
                            @csrf
                            <button type="submit" style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px;">
                                Add to Planned
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>