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

                        <form method="POST" action="/media/{{ $item->id }}/planned" style="margin-bottom: 16px;">
                            @csrf
                            <button type="submit" style="background-color: #3b82f6; color: white; padding: 8px 16px; border-radius: 6px;">
                                Add to Planned
                            </button>
                        </form>

                        <form method="POST" action="{{ route('reviews.store', $item->id) }}" style="border-top: 1px solid #444; padding-top: 16px;">
                            @csrf

                            <label style="display: block; margin-bottom: 6px;">
                                Rating
                            </label>

                            <select name="rating" required style="color: black; padding: 6px; border-radius: 6px; margin-bottom: 10px; width: 180px;">
                                <option value="">Select rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                            <label style="display: block; margin-bottom: 6px;">
                                Review
                            </label>

                            <textarea name="comment" rows="3" placeholder="Write your review..." style="width: 100%; color: black; padding: 8px; border-radius: 6px; margin-bottom: 10px;"></textarea>

                            <button type="submit" style="background-color: #22c55e; color: white; padding: 8px 16px; border-radius: 6px;">
                                Submit Review
                            </button>
                        </form>

                        @if($item->reviews->count() > 0)
                            <div style="margin-top: 20px; border-top: 1px solid #444; padding-top: 16px;">

                                <h3 style="margin-bottom: 12px; font-size: 18px;">
                                    Reviews
                                </h3>

                                @foreach($item->reviews as $review)
                                    <div style="background-color: #3a3a3a; padding: 12px; border-radius: 8px; margin-bottom: 10px;">

                                        <p style="margin-bottom: 6px;">
                                            <strong>Rating:</strong> {{ $review->rating }}/5
                                        </p>

                                        <p style="color: #d1d5db;">
                                            {{ $review->comment }}
                                        </p>

                                    </div>
                                @endforeach

                            </div>
                        @endif

                    </div>

                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>