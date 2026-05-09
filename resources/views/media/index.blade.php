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

            <form method="GET" action="/media" style="margin-bottom: 24px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search movies or series..."
                    style="background-color: #2a2a2a; color: white; padding: 10px; border-radius: 6px; border: 1px solid #444; width: 260px;"
                >

                <select name="type" style="background-color: #2a2a2a; color: white; padding: 10px; border-radius: 6px; border: 1px solid #444; width: 180px;">
                    <option value="">All Media</option>
                    <option value="movie" {{ request('type') == 'movie' ? 'selected' : '' }}>Movies</option>
                    <option value="series" {{ request('type') == 'series' ? 'selected' : '' }}>Series</option>
                    <option value="animation" {{ request('type') == 'animation' ? 'selected' : '' }}>Animation</option>
                </select>

                <select name="genre" style="background-color: #2a2a2a; color: white; padding: 10px; border-radius: 6px; border: 1px solid #444; width: 240px;">
                    <option value="">All Genres</option>
                    <option value="Action" {{ request('genre') == 'Action' ? 'selected' : '' }}>Action</option>
                    <option value="Adventure" {{ request('genre') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                    <option value="Animation" {{ request('genre') == 'Animation' ? 'selected' : '' }}>Animation</option>
                    <option value="Biography" {{ request('genre') == 'Biography' ? 'selected' : '' }}>Biography</option>
                    <option value="Comedy" {{ request('genre') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
                    <option value="Crime" {{ request('genre') == 'Crime' ? 'selected' : '' }}>Crime</option>
                    <option value="Documentary" {{ request('genre') == 'Documentary' ? 'selected' : '' }}>Documentary</option>
                    <option value="Drama" {{ request('genre') == 'Drama' ? 'selected' : '' }}>Drama</option>
                    <option value="Family" {{ request('genre') == 'Family' ? 'selected' : '' }}>Family</option>
                    <option value="Fantasy" {{ request('genre') == 'Fantasy' ? 'selected' : '' }}>Fantasy</option>
                    <option value="History" {{ request('genre') == 'History' ? 'selected' : '' }}>History</option>
                    <option value="Horror" {{ request('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
                    <option value="Mystery" {{ request('genre') == 'Mystery' ? 'selected' : '' }}>Mystery</option>
                    <option value="Romance" {{ request('genre') == 'Romance' ? 'selected' : '' }}>Romance</option>
                    <option value="Sci-Fi" {{ request('genre') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
                    <option value="Sport" {{ request('genre') == 'Sport' ? 'selected' : '' }}>Sport</option>
                    <option value="Thriller" {{ request('genre') == 'Thriller' ? 'selected' : '' }}>Thriller</option>
                    <option value="TV Show" {{ request('genre') == 'TV Show' ? 'selected' : '' }}>TV Show</option>
                    <option value="War" {{ request('genre') == 'War' ? 'selected' : '' }}>War</option>
                </select>

                <div style="display: flex; gap: 10px;">

    <select name="year_from" style="background-color: #2a2a2a; color: white; padding: 10px; border-radius: 6px; border: 1px solid #444; width: 160px;">

        <option value="">From Year</option>

        @for($year = 2026; $year >= 1970; $year--)
            <option value="{{ $year }}" {{ request('year_from') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor

    </select>

    <select name="year_to" style="background-color: #2a2a2a; color: white; padding: 10px; border-radius: 6px; border: 1px solid #444; width: 160px;">

        <option value="">To Year</option>

        @for($year = 2026; $year >= 1970; $year--)
            <option value="{{ $year }}" {{ request('year_to') == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endfor

    </select>

</div>

                <button type="submit" style="background-color: #3b82f6; color: white; padding: 10px 16px; border-radius: 6px;">
                    Search
                </button>

            </form>

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
                            {{ ucfirst($item->type) }} • {{ $item->genre }} • {{ $item->year }}
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

                            <label style="display: block; margin-bottom: 6px;">Rating</label>

                            <select name="rating" required style="color: black; padding: 6px; border-radius: 6px; margin-bottom: 10px; width: 180px;">
                                <option value="">Select rating</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>

                            <label style="display: block; margin-bottom: 6px;">Review</label>

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