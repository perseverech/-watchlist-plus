{{-- ============================================================
     FILE: resources/views/media/show.blade.php
     Media detail page — poster, info, library buttons, reviews

     ⚠️ DEPENDS ON AL'ZHANA — MediaController@show must pass:
       $media = [
         'id'          => int,
         'title'       => string,
         'poster'      => string (URL),
         'backdrop'    => string (wide banner URL — can be null),
         'description' => string,
         'rating'      => float,
         'type'        => 'movie' | 'tv',
         'year'        => int,
         'genres'      => ['Action', 'Drama', ...],
         'runtime'     => int (minutes — optional),
       ]
       $reviews    = Review::with('user')->where('media_id', ...)->latest()->get()
       $userStatus = 'planned' | 'watched' | null  (current user's status for this media)
     ============================================================ --}}
@extends('layouts.app')
@section('title', $media['title'] ?? 'Media Detail')

@section('content')

{{-- ===== HERO BACKDROP ===== --}}
<div class="media-hero"
    @if(!empty($media['backdrop']))
        style="background-image: linear-gradient(to bottom, rgba(10,10,15,0.25) 0%, rgba(10,10,15,1) 70%), url('{{ $media['backdrop'] }}');"
    @endif
>
    <div class="media-hero__content">

        {{-- Poster --}}
        <div class="media-hero__poster">
            @if(!empty($media['poster']))
                <img src="{{ $media['poster'] }}" alt="{{ $media['title'] }}">
            @else
                <div class="media-hero__no-poster">No Poster</div>
            @endif
        </div>

        {{-- Info --}}
        <div class="media-hero__info">

            {{-- Badges row --}}
            <div class="media-hero__badges">
                <span class="badge badge--type">{{ strtoupper($media['type'] ?? 'MOVIE') }}</span>
                @if(!empty($media['year']))
                    <span class="badge badge--meta">{{ $media['year'] }}</span>
                @endif
                @if(!empty($media['runtime']))
                    <span class="badge badge--meta">{{ $media['runtime'] }} min</span>
                @endif
            </div>

            <h1 class="media-hero__title">{{ $media['title'] }}</h1>

            {{-- Rating --}}
            <div class="media-hero__rating">
                <span class="rating-star">⭐</span>
                <span class="rating-value">{{ number_format($media['rating'] ?? 0, 1) }}</span>
                <span class="rating-max">/10</span>
            </div>

            {{-- Genres --}}
            @if(!empty($media['genres']))
                <div class="media-hero__genres">
                    @foreach($media['genres'] as $genre)
                        <span class="genre-pill">{{ $genre }}</span>
                    @endforeach
                </div>
            @endif

            {{-- Description --}}
            <p class="media-hero__description">
                {{ $media['description'] ?? 'No description available.' }}
            </p>

            {{-- ===== LIBRARY BUTTONS — only for logged-in users ===== --}}
            @auth
                <div class="library-actions" id="library-actions">
                    <button
                        id="btn-planned"
                        class="lib-btn {{ ($userStatus ?? '') === 'planned' ? 'lib-btn--active' : '' }}"
                        onclick="updateLibraryStatus({{ $media['id'] }}, 'planned')"
                    >
                        📋 {{ __('messages.planned') }}
                    </button>
                    <button
                        id="btn-watched"
                        class="lib-btn lib-btn--watched {{ ($userStatus ?? '') === 'watched' ? 'lib-btn--active' : '' }}"
                        onclick="updateLibraryStatus({{ $media['id'] }}, 'watched')"
                    >
                        ✅ {{ __('messages.watched') }}
                    </button>
                    {{-- Remove button — only if already in library --}}
                    @if(!empty($userStatus))
                        <button id="btn-remove" class="lib-btn lib-btn--remove" onclick="removeFromLibrary({{ $media['id'] }})">
                            ✕ Remove
                        </button>
                    @endif
                </div>
            @endauth

            @guest
                <p class="guest-hint">
                    <a href="{{ route('login') }}">Log in</a> to add this to your library.
                </p>
            @endguest

        </div>
    </div>
</div>

{{-- ===== REVIEWS SECTION ===== --}}
<section class="reviews-section">

    <div class="section-header">
        <h2 class="section-title">Reviews</h2>
        <div class="section-line"></div>
    </div>

    {{-- Review form — logged-in users only --}}
    @auth
        @include('partials.review-form', ['mediaId' => $media['id']])
    @endauth

    @guest
        <p class="guest-hint" style="margin-bottom:1.5rem;">
            <a href="{{ route('login') }}">Log in</a> to write a review.
        </p>
    @endguest

    {{-- Reviews list --}}
    <div id="reviews-list">
        {{-- ⚠️ DEPENDS ON AL'ZHANA: $reviews must have ->user->username, ->rating, ->content, ->id, ->user_id --}}
        @forelse($reviews as $review)
            @include('partials.review-card', ['review' => $review])
        @empty
            <p class="empty-reviews" id="no-reviews-msg">No reviews yet. Be the first!</p>
        @endforelse
    </div>

</section>

@endsection

@push('styles')
<style>
/* ===== HERO ===== */
.media-hero {
    min-height: 560px;
    background-color: var(--color-bg);
    background-size: cover;
    background-position: center 20%;
    display: flex;
    align-items: flex-end;
    padding: 0 2.5rem 3.5rem;
}
.media-hero__content {
    max-width: 1100px;
    margin: 0 auto;
    width: 100%;
    display: flex;
    gap: 3rem;
    align-items: flex-end;
}

/* Poster */
.media-hero__poster {
    flex-shrink: 0;
    width: 210px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid var(--color-border);
    box-shadow: 0 24px 60px rgba(0,0,0,0.7);
}
.media-hero__poster img { width: 100%; display: block; }
.media-hero__no-poster {
    width: 100%;
    aspect-ratio: 2/3;
    background: var(--color-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-muted);
    font-size: 0.8rem;
}

/* Info */
.media-hero__info { flex: 1; min-width: 0; }
.media-hero__badges { display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem; }
.badge {
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 0.22rem 0.6rem;
    border-radius: 4px;
}
.badge--type { background: var(--color-accent); color: #fff; }
.badge--meta {
    background: var(--color-surface);
    color: var(--color-muted);
    border: 1px solid var(--color-border);
}
.media-hero__title {
    font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 4rem);
    letter-spacing: 1px;
    line-height: 1.05;
    margin-bottom: 0.8rem;
}
.media-hero__rating {
    display: flex;
    align-items: baseline;
    gap: 0.3rem;
    margin-bottom: 1rem;
}
.rating-star  { font-size: 1.1rem; }
.rating-value { font-size: 1.8rem; font-weight: 700; color: var(--color-accent2); line-height: 1; }
.rating-max   { font-size: 0.9rem; color: var(--color-muted); }
.media-hero__genres { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem; }
.genre-pill {
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--color-border);
    border-radius: 20px;
    padding: 0.2rem 0.7rem;
    font-size: 0.78rem;
    color: var(--color-muted);
}
.media-hero__description {
    color: var(--color-muted);
    font-size: 0.95rem;
    line-height: 1.65;
    max-width: 580px;
    margin-bottom: 1.8rem;
}

/* Library buttons */
.library-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
.lib-btn {
    padding: 0.6rem 1.3rem;
    border-radius: 8px;
    border: 1px solid var(--color-border);
    background: var(--color-surface);
    color: var(--color-muted);
    font-family: var(--font-body);
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
}
.lib-btn:hover { border-color: var(--color-accent); color: var(--color-text); }
.lib-btn--active {
    border-color: var(--color-accent);
    color: var(--color-text);
    background: rgba(232,70,42,0.12);
}
.lib-btn--remove { color: #e07070; border-color: transparent; }
.lib-btn--remove:hover { background: rgba(224,112,112,0.08); border-color: rgba(224,112,112,0.3); }

.guest-hint { color: var(--color-muted); font-size: 0.9rem; }
.guest-hint a { color: var(--color-accent); text-decoration: none; }
.guest-hint a:hover { text-decoration: underline; }

/* ===== REVIEWS SECTION ===== */
.reviews-section {
    max-width: 900px;
    margin: 0 auto;
    padding: 3rem 2.5rem 4rem;
}
.empty-reviews { color: var(--color-muted); font-size: 0.9rem; padding: 1.5rem 0; }
</style>
@endpush

@push('scripts')
<script>
// ============================================================
//  LIBRARY STATUS — AJAX (show page)
//  ⚠️ DEPENDS ON AL'ZHANA:
//    POST /library/update → { media_id, status } → { success: true }
//    POST /library/remove → { media_id }         → { success: true }
// ============================================================

async function updateLibraryStatus(mediaId, status) {
    try {
        const res  = await fetch('/library/update', {
            method: 'POST',
            headers: {
                'Content-Type':     'application/json',
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
            body: JSON.stringify({ media_id: mediaId, status })
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('btn-planned').classList.toggle('lib-btn--active', status === 'planned');
            document.getElementById('btn-watched').classList.toggle('lib-btn--active', status === 'watched');

            // Show remove button if not already there
            if (!document.getElementById('btn-remove')) {
                document.getElementById('library-actions').insertAdjacentHTML('beforeend',
                    `<button id="btn-remove" class="lib-btn lib-btn--remove" onclick="removeFromLibrary(${mediaId})">✕ Remove</button>`
                );
            }
        }
    } catch (err) {
        console.error('Library update error:', err);
    }
}

async function removeFromLibrary(mediaId) {
    try {
        const res  = await fetch('/library/remove', {
            method: 'POST',
            headers: {
                'Content-Type':     'application/json',
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
            body: JSON.stringify({ media_id: mediaId })
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('btn-planned')?.classList.remove('lib-btn--active');
            document.getElementById('btn-watched')?.classList.remove('lib-btn--active');
            document.getElementById('btn-remove')?.remove();
        }
    } catch (err) {
        console.error('Library remove error:', err);
    }
}
</script>
@endpush

