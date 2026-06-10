@php
    $id = data_get($item, 'id');
    $title = data_get($item, 'title');
    $poster = data_get($item, 'poster');
    $rating = data_get($item, 'rating', 0);
    $type = data_get($item, 'type', 'movie');
    $year = data_get($item, 'year');
@endphp

<a href="{{ route('media.show', $id) }}" class="media-card">
    <div class="media-card__poster">

        @if(!empty($poster))
            <img
                src="{{ $poster }}"
                alt="{{ $title }}"
                loading="lazy"
                onerror="this.src='/images/no-poster.svg'"
            >
        @else
            <div class="media-card__no-poster">
                <span>No Image</span>
            </div>
        @endif

        <div class="media-card__badge">
            {{ strtoupper($type) }}
        </div>

        <div class="media-card__overlay">
            <span class="media-card__view-btn">View Details →</span>
        </div>

    </div>

    <div class="media-card__info">
        <h3 class="media-card__title">{{ $title }}</h3>

        <div class="media-card__meta">
            <span class="media-card__rating">
                ⭐ {{ number_format($rating, 1) }}
            </span>

            @if(!empty($year))
                <span class="media-card__year">{{ $year }}</span>
            @endif
        </div>
    </div>
</a>

<style>
.media-card {
    display: block;
    text-decoration: none;
    color: var(--color-text);
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
}

.media-card:hover {
    transform: translateY(-6px);
    border-color: var(--color-accent);
    box-shadow: 0 16px 40px rgba(232,70,42,0.15);
}

.media-card__poster {
    position: relative;
    aspect-ratio: 2/3;
    overflow: hidden;
    background: var(--color-bg);
}

.media-card__poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.media-card__no-poster {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--color-muted);
    font-size: 0.78rem;
    background: repeating-linear-gradient(
        45deg,
        var(--color-bg), var(--color-bg) 10px,
        var(--color-border) 10px, var(--color-border) 11px
    );
}

.media-card__badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background: rgba(10,10,15,0.85);
    color: var(--color-accent);
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 1px;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}

.media-card__overlay {
    position: absolute;
    inset: 0;
    background: rgba(10,10,15,0.72);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s;
}

.media-card:hover .media-card__overlay {
    opacity: 1;
}

.media-card__view-btn {
    color: #fff;
    font-size: 0.8rem;
    font-weight: 600;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.45rem 0.9rem;
    border-radius: 6px;
}

.media-card__info {
    padding: 0.8rem;
}

.media-card__title {
    font-size: 0.88rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.35rem;
}

.media-card__meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.media-card__rating {
    font-size: 0.78rem;
    color: var(--color-accent2);
}

.media-card__year {
    font-size: 0.72rem;
    color: var(--color-muted);
}
</style>