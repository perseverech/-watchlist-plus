<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            My Library
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
                My WatchList
            </h1>

            @if($items->isEmpty())
                <div style="background-color: #2a2a2a; color: white; padding: 20px; border-radius: 10px;">
                    Your library is empty.
                </div>
            @endif

            @foreach($items as $item)
                <div style="display: flex; gap: 24px; background-color: #2a2a2a; padding: 20px; border-radius: 10px; margin-bottom: 20px; color: white;">

                    <div style="width: 120px; height: 170px; background-color: #444; display: flex; align-items: center; justify-content: center; color: #aaa; border-radius: 6px;">
                        Poster
                    </div>

                    <div style="flex: 1;">
                        <h2 style="font-size: 24px; margin-bottom: 6px;">
                            {{ $item->mediaItem->title }}
                        </h2>

                        <p style="color: #9ca3af; margin-bottom: 8px;">
                            {{ ucfirst($item->mediaItem->type) }}
                        </p>

                        <p style="margin-bottom: 16px;">
                            <strong>Status:</strong> {{ ucfirst($item->status) }}
                        </p>

                        <div style="display: flex; gap: 10px;">
                            @if($item->status !== 'watched')
                                <form method="POST" action="{{ route('library.watched', $item->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" style="background-color: #22c55e; color: white; padding: 8px 16px; border-radius: 6px;">
                                        Mark as Watched
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('library.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" style="background-color: #dc2626; color: white; padding: 8px 16px; border-radius: 6px;">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>