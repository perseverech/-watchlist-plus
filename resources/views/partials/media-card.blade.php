@php
    $id = data_get($item, 'id');
    $title = data_get($item, 'title');
    $poster = data_get($item, 'poster');
    $rating = data_get($item, 'rating', 0);
    $type = data_get($item, 'type', 'movie');
    $year = data_get($item, 'year');

    if (empty($poster)) {
        $map = [
            'Inception' => '/images/posters/inception.jpg',
            'Breaking Bad' => '/images/posters/breaking-bad.jpg',
            'Interstellar' => '/images/posters/interstellar.jpg',
            'Spider-Man: Into the Spider-Verse' => '/images/posters/spider-verse.jpg',
            'Frozen' => '/images/posters/frozen.jpg',
        ];

        $poster = $map[$title] ?? null;
    }
@endphp

<a href="{{ route('media.show', $id) }}" class="media-card">
    <div class="media-card__poster">

        @if($poster)
            <img
                src="{{ $poster }}"
                alt="{{ $title }}"
                loading="lazy"
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
                ⭐ {{ number_format($rating,1) }}
            </span>

            @if($year)
                <span class="media-card__year">{{ $year }}</span>
            @endif
        </div>
    </div>
</a>

<style>
.media-card{
display:block;
text-decoration:none;
color:var(--color-text);
background:var(--color-surface);
border:1px solid var(--color-border);
border-radius:10px;
overflow:hidden;
transition:.25s;
}

.media-card:hover{
transform:translateY(-6px);
border-color:var(--color-accent);
box-shadow:0 16px 40px rgba(232,70,42,.15);
}

.media-card__poster{
position:relative;
aspect-ratio:2/3;
overflow:hidden;
background:var(--color-bg);
}

.media-card__poster img{
width:100%;
height:100%;
object-fit:cover;
display:block;
}

.media-card__no-poster{
width:100%;
height:100%;
display:flex;
align-items:center;
justify-content:center;
color:var(--color-muted);
background:#111;
}

.media-card__badge{
position:absolute;
top:.5rem;
left:.5rem;
background:rgba(10,10,15,.85);
color:var(--color-accent);
font-size:.62rem;
font-weight:800;
letter-spacing:1px;
padding:.2rem .5rem;
border-radius:4px;
}

.media-card__overlay{
position:absolute;
inset:0;
background:rgba(10,10,15,.72);
display:flex;
align-items:center;
justify-content:center;
opacity:0;
transition:.25s;
}

.media-card:hover .media-card__overlay{
opacity:1;
}

.media-card__view-btn{
color:#fff;
font-size:.8rem;
font-weight:600;
border:1px solid rgba(255,255,255,.3);
padding:.45rem .9rem;
border-radius:6px;
}

.media-card__info{
padding:.8rem;
}

.media-card__title{
font-size:.88rem;
font-weight:600;
white-space:nowrap;
overflow:hidden;
text-overflow:ellipsis;
margin-bottom:.35rem;
}

.media-card__meta{
display:flex;
justify-content:space-between;
align-items:center;
}

.media-card__rating{
font-size:.78rem;
color:var(--color-accent2);
}

.media-card__year{
font-size:.72rem;
color:var(--color-muted);
}
</style>