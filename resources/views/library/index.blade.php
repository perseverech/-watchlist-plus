{{-- ============================================================
     FILE: resources/views/library/index.blade.php
     "My Library" page — planned and watched tabs

     ⚠️ DEPENDS ON AL'ZHANA — UserController@library must pass:
       $planned — collection of media item arrays (status = 'planned')
                  each with: id, title, poster, rating, type, year
       $watched — collection of media item arrays (status = 'watched')
     ============================================================ --}}
@extends('layouts.app')
@section('title', __('messages.my_library'))

@section('content')

<div class="library-page">

    {{-- Header --}}
    <div class="library-page__header">
        <h1 class="library-page__title">{{ __('messages.my_library') }}</h1>
        <p class="library-page__sub">
            <span>{{ $planned->count() }} {{ __('messages.planned') }}</span>
            &middot;
            <span>{{ $watched->count() }} {{ __('messages.watched') }}</span>
        </p>
    </div>

    {{-- Tab buttons --}}
    <div class="tabs">
        <button class="tab-btn tab-btn--active" id="tab-planned-btn" onclick="showTab('planned')">
            📋 {{ __('messages.planned') }}
            <span class="tab-count">{{ $planned->count() }}</span>
        </button>
        <button class="tab-btn" id="tab-watched-btn" onclick="showTab('watched')">
            ✅ {{ __('messages.watched') }}
            <span class="tab-count">{{ $watched->count() }}</span>
        </button>
    </div>

    {{-- Planned tab content --}}
    <div id="tab-planned" class="tab-content">
        @if($planned->isEmpty())
            <div class="empty-library">
                <span>📋</span>
                <p>Nothing in your planned list yet.</p>
                <a href="{{ route('home') }}" class="btn btn--accent">Browse Media</a>
            </div>
        @else
            <div class="media-grid">
                {{-- ⚠️ DEPENDS ON AL'ZHANA: each $item must be an array or arrayable
                     with keys: id, title, poster, rating, type, year --}}
                @foreach($planned as $item)
                    @include('partials.media-card', ['item' => is_array($item) ? $item : $item->toArray()])
                @endforeach
            </div>
        @endif
    </div>

    {{-- Watched tab content --}}
    <div id="tab-watched" class="tab-content" style="display:none">
        @if($watched->isEmpty())
            <div class="empty-library">
                <span>✅</span>
                <p>Nothing marked as watched yet.</p>
                <a href="{{ route('home') }}" class="btn btn--accent">Browse Media</a>
            </div>
        @else
            <div class="media-grid">
                @foreach($watched as $item)
                    @include('partials.media-card', ['item' => is_array($item) ? $item : $item->toArray()])
                @endforeach
            </div>
        @endif
    </div>

</div>

@endsection

@push('styles')
<style>
.library-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 3rem 2.5rem 4rem;
}

.library-page__header { margin-bottom: 2rem; }
.library-page__title {
    font-family: var(--font-display);
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    letter-spacing: 1px;
}
.library-page__sub {
    color: var(--color-muted);
    font-size: 0.9rem;
    margin-top: 0.4rem;
    display: flex;
    gap: 0.5rem;
}

/* ===== TABS ===== */
.tabs {
    display: flex;
    gap: 0;
    margin-bottom: 2rem;
    border-bottom: 1px solid var(--color-border);
}
.tab-btn {
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: var(--color-muted);
    font-family: var(--font-body);
    font-size: 0.95rem;
    font-weight: 500;
    padding: 0.7rem 1.4rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    margin-bottom: -1px; /* overlap border-bottom */
}
.tab-btn:hover { color: var(--color-text); }
.tab-btn--active {
    color: var(--color-text);
    border-bottom-color: var(--color-accent);
}
.tab-count {
    background: var(--color-border);
    color: var(--color-muted);
    border-radius: 20px;
    padding: 0.1rem 0.5rem;
    font-size: 0.72rem;
    font-weight: 600;
}
.tab-btn--active .tab-count {
    background: rgba(232,70,42,0.15);
    color: var(--color-accent);
}

/* ===== MEDIA GRID ===== */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 1.2rem;
}

/* ===== EMPTY STATE ===== */
.empty-library {
    padding: 5rem 2rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    color: var(--color-muted);
}
.empty-library span { font-size: 3.5rem; }
.empty-library p { font-size: 0.95rem; }
</style>
@endpush

@push('scripts')
<script>
function showTab(tab) {
    const plannedEl    = document.getElementById('tab-planned');
    const watchedEl    = document.getElementById('tab-watched');
    const btnPlanned   = document.getElementById('tab-planned-btn');
    const btnWatched   = document.getElementById('tab-watched-btn');

    if (tab === 'planned') {
        plannedEl.style.display = 'block';
        watchedEl.style.display = 'none';
        btnPlanned.classList.add('tab-btn--active');
        btnWatched.classList.remove('tab-btn--active');
    } else {
        watchedEl.style.display = 'block';
        plannedEl.style.display = 'none';
        btnWatched.classList.add('tab-btn--active');
        btnPlanned.classList.remove('tab-btn--active');
    }

    // Update URL hash so refreshing keeps the tab
    window.location.hash = tab;
}

// Restore tab from URL hash on load (e.g. /library#watched)
const hash = window.location.hash.replace('#', '');
if (hash === 'watched' || hash === 'planned') {
    showTab(hash);
}
</script>
@endpush
