@php
    $posterMap = [
        'Inception' => '/images/posters/inception.jpg',
        'Breaking Bad' => '/images/posters/breaking-bad.jpg',
        'Interstellar' => '/images/posters/interstellar.jpg',
        'Spider-Man: Into the Spider-Verse' => '/images/posters/spider-verse.jpg',
        'Frozen' => '/images/posters/frozen.jpg',
    ];

    $poster = $media->poster ?? null;

    if (empty($poster)) {
        $poster = $posterMap[$media->title] ?? null;
    }
@endphp

@extends('layouts.app')

@section('title', $media->title ?? 'Media Detail')

@section('content')

<div style="max-width: 1000px; margin: 0 auto; padding: 48px 24px;">

    <a href="{{ route('home') }}" style="color: #e8462a; text-decoration: none;">
        Back to Home
    </a>

    <div style="display: flex; gap: 32px; margin-top: 32px; align-items: flex-start;">
        <div style="width: 220px; height: 330px; background: #13131a; border: 1px solid #1e1e2e; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; color: #6b6b80;">
            @if($poster)
                <img src="{{ $poster }}" alt="{{ $media->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                No Poster
            @endif
        </div>

        <div style="flex: 1;">
            <p style="color: #e8462a; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">
                {{ $media->type }}
                @if($media->year)
                    • {{ $media->year }}
                @endif
            </p>

            <h1 style="font-size: 52px; font-family: var(--font-display); letter-spacing: 1px; margin-bottom: 10px;">
                {{ $media->title }}
            </h1>

            <div style="font-size:22px; color:#f5c542; font-weight:700; margin-bottom:18px;">
                ⭐ {{ number_format($media->rating, 1) }} / 10
            </div>

            <p style="color: #6b6b80; margin-bottom: 24px; max-width: 600px;">
                {{ $media->description }}
            </p>

            @auth
                <div style="display: flex; gap: 12px; margin-bottom: 24px; flex-wrap: wrap;">
                    <form method="POST" action="{{ route('library.update') }}">
                        @csrf
                        <input type="hidden" name="media_item_id" value="{{ $media->id }}">
                        <input type="hidden" name="status" value="planned">

                        <button type="submit" style="background: {{ ($userStatus ?? '') === 'planned' ? '#e8462a' : '#13131a' }}; color: #e8e8f0; border: 1px solid #1e1e2e; padding: 10px 18px; border-radius: 8px; cursor: pointer;">
                            Planned
                        </button>
                    </form>

                    <form method="POST" action="{{ route('library.update') }}">
                        @csrf
                        <input type="hidden" name="media_item_id" value="{{ $media->id }}">
                        <input type="hidden" name="status" value="watched">

                        <button type="submit" style="background: {{ ($userStatus ?? '') === 'watched' ? '#e8462a' : '#13131a' }}; color: #e8e8f0; border: 1px solid #1e1e2e; padding: 10px 18px; border-radius: 8px; cursor: pointer;">
                            Watched
                        </button>
                    </form>

                    @if(!empty($userStatus))
                        <form method="POST" action="{{ route('library.remove') }}">
                            @csrf
                            <input type="hidden" name="media_item_id" value="{{ $media->id }}">

                            <button type="submit" style="background: #7f1d1d; color: white; border: 1px solid #991b1b; padding: 10px 18px; border-radius: 8px; cursor: pointer;">
                                Remove
                            </button>
                        </form>
                    @endif
                </div>
            @endauth
        </div>
    </div>

    <div style="margin-top: 48px;">
        <h2 style="font-family: var(--font-display); font-size: 32px; margin-bottom: 24px;">
            Reviews
        </h2>

        @auth
            <form method="POST" action="{{ route('reviews.store') }}" style="background: #13131a; border: 1px solid #1e1e2e; border-radius: 12px; padding: 24px; margin-bottom: 32px;">
                @csrf

                <input type="hidden" name="media_item_id" value="{{ $media->id }}">

                <label style="display: block; margin-bottom: 8px;">
                    Rating
                </label>

                <select name="rating" required style="width: 180px; padding: 10px; margin-bottom: 16px; background: #0a0a0f; color: #e8e8f0; border: 1px solid #1e1e2e; border-radius: 8px;">
                    <option value="">Select rating</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <label style="display: block; margin-bottom: 8px;">
                    Review
                </label>

                <textarea name="comment" rows="4" placeholder="Write your review..." style="width: 100%; padding: 12px; background: #0a0a0f; color: #e8e8f0; border: 1px solid #1e1e2e; border-radius: 8px; margin-bottom: 16px;"></textarea>

                <button type="submit" style="background: #e8462a; color: white; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer;">
                    Submit Review
                </button>
            </form>
        @endauth

        @forelse($reviews as $review)
            <div style="background: #13131a; border: 1px solid #1e1e2e; border-radius: 12px; padding: 18px; margin-bottom: 12px;">
                <p style="color: #e8e8f0; font-weight: 700; margin-bottom: 6px;">
                    {{ $review->user->name ?? 'User' }}
                </p>

                <p style="color: #f5a623; margin-bottom: 8px;">
                    Rating: {{ $review->rating }}/10
                </p>

                <p style="color: #e8e8f0;">
                    {{ $review->comment ?? $review->content }}
                </p>
                @auth
@if(auth()->id() == $review->user_id || auth()->user()->role == 'admin')
<form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="margin-top:12px;">
    @csrf
    @method('DELETE')

    <button
        type="submit"
        style="background:#c62828;color:white;border:none;padding:8px 14px;border-radius:8px;cursor:pointer;">
        Delete Review
    </button>
</form>
@endif
@endauth
            </div>
        @empty
            <p style="color: #6b6b80;">No reviews yet. Be the first!</p>
        @endforelse
    </div>

</div>

@endsection