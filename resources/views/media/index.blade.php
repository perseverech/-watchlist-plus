@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
<section class="hero">
    <div class="hero__inner">
        <h1 class="hero__title">{{ __('messages.discover') }}</h1>
        <p class="hero__sub">{{ __('messages.discover_sub') }}</p>

        <div class="search-bar">
            <div class="search-bar__input-wrap">
                <svg class="search-bar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>

                <input
                    type="text"
                    id="search-input"
                    placeholder="{{ __('messages.search_placeholder') }}"
                    autocomplete="off"
                >

                <div class="search-spinner" id="search-spinner" style="display:none"></div>
            </div>

            <select id="genre-filter" class="filter-select">
                <option value="">{{ __('messages.all_genres') }}</option>

                @foreach($genres as $genre)
                    @php
                        $genreKey = strtolower(str_replace([' ', '-'], '_', $genre->name));
                    @endphp

                    <option value="{{ $genre->id }}">
                        {{ __('messages.' . $genreKey) }}
                    </option>
                @endforeach
            </select>

            <select id="type-filter" class="filter-select">
                <option value="">{{ __('messages.all_types') }}</option>
                <option value="movie">{{ __('messages.movies') }}</option>
                <option value="tv">{{ __('messages.tv_series') }}</option>
                <option value="animation">{{ __('messages.animation') }}</option>
            </select>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="section-header">
        <h2 class="section-title" id="results-title">{{ __('messages.trending') }}</h2>
        <div class="section-line"></div>
    </div>

    <div class="media-grid skeleton-grid" id="skeleton-grid" style="display:none">
        @for($i = 0; $i < 6; $i++)
            <div class="skeleton-card">
                <div class="skeleton-poster"></div>
                <div class="skeleton-title"></div>
                <div class="skeleton-meta"></div>
            </div>
        @endfor
    </div>

    <div class="media-grid" id="media-grid">
        @forelse($trending as $item)
            @include('partials.media-card', ['item' => $item])
        @empty
            <div class="empty-state" id="empty-state-default">
                <span>🎬</span>
                <p>{{ __('messages.no_results') }}</p>
            </div>
        @endforelse
    </div>

    <div class="empty-state" id="empty-state" style="display:none">
        <span>🔍</span>
        <p>{{ __('messages.no_results') }}</p>
    </div>
</section>
@endsection

@push('styles')
<style>
.hero {
    padding: 4.5rem 2.5rem 3.5rem;
    background: radial-gradient(ellipse at 50% -10%, rgba(232,70,42,0.13) 0%, transparent 65%);
    border-bottom: 1px solid var(--color-border);
}

.hero__inner {
    max-width: 860px;
    margin: 0 auto;
    text-align: center;
}

.hero__title {
    font-family: var(--font-display);
    font-size: clamp(3.5rem, 9vw, 7rem);
    letter-spacing: 3px;
    line-height: 1;
    background: linear-gradient(140deg, var(--color-text) 30%, var(--color-muted) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.6rem;
}

.hero__sub {
    color: var(--color-muted);
    font-size: 1rem;
    margin-bottom: 2.5rem;
}

.search-bar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
    max-width: 780px;
    margin: 0 auto;
}

.search-bar__input-wrap {
    position: relative;
    flex: 1;
    min-width: 260px;
}

.search-bar__icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 17px;
    height: 17px;
    color: var(--color-muted);
    pointer-events: none;
    flex-shrink: 0;
}

#search-input {
    width: 100%;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 0.85rem 2.8rem 0.85rem 2.8rem;
    color: var(--color-text);
    font-family: var(--font-body);
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

#search-input:focus {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px rgba(232,70,42,0.08);
}

#search-input::placeholder {
    color: var(--color-muted);
}

.search-spinner {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 15px;
    border: 2px solid var(--color-border);
    border-top-color: var(--color-accent);
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to {
        transform: translateY(-50%) rotate(360deg);
    }
}

.filter-select {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 0.85rem 1rem;
    color: var(--color-text);
    font-family: var(--font-body);
    font-size: 0.9rem;
    outline: none;
    cursor: pointer;
    transition: border-color 0.2s;
    min-width: 140px;
}

.filter-select:focus {
    border-color: var(--color-accent);
}

.content-section {
    padding: 3rem 2.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 1.2rem;
}

.skeleton-grid {
    display: grid;
}

.skeleton-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    overflow: hidden;
}

.skeleton-poster {
    aspect-ratio: 2/3;
    background: linear-gradient(90deg, var(--color-border) 25%, #1a1a25 50%, var(--color-border) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
}

.skeleton-title {
    margin: 0.8rem 0.8rem 0.4rem;
    height: 13px;
    border-radius: 4px;
    background: linear-gradient(90deg, var(--color-border) 25%, #1a1a25 50%, var(--color-border) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
}

.skeleton-meta {
    margin: 0 0.8rem 0.8rem;
    height: 10px;
    width: 55%;
    border-radius: 4px;
    background: linear-gradient(90deg, var(--color-border) 25%, #1a1a25 50%, var(--color-border) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.4s infinite;
}

@keyframes shimmer {
    to {
        background-position: -200% 0;
    }
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: var(--color-muted);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.8rem;
}

.empty-state span {
    font-size: 3rem;
}

.empty-state p {
    font-size: 0.95rem;
}
</style>
@endpush

@push('scripts')
<script>
const searchInput = document.getElementById('search-input');
const genreFilter = document.getElementById('genre-filter');
const typeFilter = document.getElementById('type-filter');
const mediaGrid = document.getElementById('media-grid');
const skeletonGrid = document.getElementById('skeleton-grid');
const emptyState = document.getElementById('empty-state');
const spinner = document.getElementById('search-spinner');
const resultsTitle = document.getElementById('results-title');

const translations = {
    filteredResults: @json(__('messages.filtered_results')),
    resultsFor: @json(__('messages.results_for')),
    somethingWrong: @json(__('messages.something_wrong')),
    noImage: @json(__('messages.no_image')),
    viewDetails: @json(__('messages.view_details')),
    movie: @json(__('messages.movie')),
    series: @json(__('messages.series')),
    animation: @json(__('messages.animation')),
};

function translateType(type) {
    const normalized = (type || 'movie').toLowerCase();

    if (normalized === 'series' || normalized === 'tv') {
        return translations.series;
    }

    if (normalized === 'animation') {
        return translations.animation;
    }

    return translations.movie;
}

function buildCard(item) {
    const poster = item.poster
        ? `<img src="${item.poster}" alt="${item.title}" loading="lazy" onerror="this.src='/images/no-poster.svg'">`
        : `<div class="media-card__no-poster"><span>${translations.noImage}</span></div>`;

    return `
        <a href="/media/${item.id}" class="media-card">
            <div class="media-card__poster">
                ${poster}
                <div class="media-card__badge">${translateType(item.type)}</div>
                <div class="media-card__overlay">
                    <span class="media-card__view-btn">${translations.viewDetails} →</span>
                </div>
            </div>
            <div class="media-card__info">
                <h3 class="media-card__title">${item.title}</h3>
                <div class="media-card__meta">
                    <span class="media-card__rating">⭐ ${parseFloat(item.rating || 0).toFixed(1)}</span>
                    ${item.year ? `<span class="media-card__year">${item.year}</span>` : ''}
                </div>
            </div>
        </a>`;
}

function showSkeleton() {
    mediaGrid.style.display = 'none';
    emptyState.style.display = 'none';
    skeletonGrid.style.display = 'grid';
    spinner.style.display = 'block';
}

function hideSkeleton() {
    skeletonGrid.style.display = 'none';
    spinner.style.display = 'none';
}

async function fetchResults() {
    const query = searchInput.value.trim();
    const genre = genreFilter.value;
    const type = typeFilter.value;

    if (!query && !genre && !type) {
        window.location.reload();
        return;
    }

    showSkeleton();

    resultsTitle.textContent = query
        ? `${translations.resultsFor} "${query}"`
        : translations.filteredResults;

    try {
        const params = new URLSearchParams({ query, genre, type });
        const response = await fetch(`/search?${params}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error('Search failed');
        }

        const data = await response.json();

        hideSkeleton();

        if (!data.length) {
            mediaGrid.style.display = 'none';
            emptyState.style.display = 'flex';
        } else {
            emptyState.style.display = 'none';
            mediaGrid.style.display = 'grid';
            mediaGrid.innerHTML = data.map(buildCard).join('');
        }
    } catch (err) {
        hideSkeleton();
        mediaGrid.style.display = 'grid';
        mediaGrid.innerHTML = `<div class="empty-state"><p>${translations.somethingWrong}</p></div>`;
        console.error('Search error:', err);
    }
}

let debounceTimer;

searchInput.addEventListener('input', () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchResults, 400);
});

genreFilter.addEventListener('change', fetchResults);
typeFilter.addEventListener('change', fetchResults);
</script>
@endpush