@extends('layouts.app')

@section('title', 'My Library')

@section('content')

<div class="library-page">

    <h1 class="library-title">{{ __('messages.my_library') }}</h1>

    <p class="library-subtitle">
    {{ $planned->count() }} {{ __('messages.planned') }}
    ·
    {{ $watched->count() }} {{ __('messages.watched') }}
</p>

    <div class="library-tabs">
        <button id="plannedBtn" class="library-tab active" onclick="showTab('planned')">
    {{ __('messages.planned') }}
    <span>{{ $planned->count() }}</span>
</button>

        <button id="watchedBtn" class="library-tab" onclick="showTab('watched')">
    {{ __('messages.watched') }}
    <span>{{ $watched->count() }}</span>
</button>
        </button>
    </div>

    <div id="plannedTab" class="tab-content">
        @if($planned->isEmpty())
            <p class="empty-text">Nothing in your planned list yet.</p>
        @else
            <div class="library-grid">
                @foreach($planned as $item)
                    @php
                        $media = $item->mediaItem;
                    @endphp

                    @if($media)
                        <div class="library-card">
                            @include('partials.media-card', [
                                'item' => [
                                    'id' => $media->id,
                                    'title' => $media->title,
                                    'poster' => $media->poster ?? null,
                                    'rating' => round($media->reviews->avg('rating') ?? 0, 1),
                                    'type' => $media->type,
                                    'year' => $media->year,
                                ]
                            ])

                            <form method="POST" action="{{ route('library.remove') }}">
                                @csrf
                                <input type="hidden" name="media_item_id" value="{{ $media->id }}">

                                <button class="remove-btn">
    {{ __('messages.remove') }}
</button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <div id="watchedTab" class="tab-content" style="display:none;">
        @if($watched->isEmpty())
            <p class="empty-text">Nothing marked as watched yet.</p>
        @else
            <div class="library-grid">
                @foreach($watched as $item)
                    @php
                        $media = $item->mediaItem;
                    @endphp

                    @if($media)
                        <div class="library-card">
                            @include('partials.media-card', [
                                'item' => [
                                    'id' => $media->id,
                                    'title' => $media->title,
                                    'poster' => $media->poster ?? null,
                                    'rating' => round($media->reviews->avg('rating') ?? 0, 1),
                                    'type' => $media->type,
                                    'year' => $media->year,
                                ]
                            ])

                            <form method="POST" action="{{ route('library.remove') }}">
                                @csrf
                                <input type="hidden" name="media_item_id" value="{{ $media->id }}">

                                <button type="submit">
    Remove
</button>
                            </form>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

</div>

<style>
.library-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 24px;
}

.library-title {
    font-family: var(--font-display);
    font-size: 72px;
    margin-bottom: 16px;
}

.library-subtitle {
    color: var(--color-muted);
    margin-bottom: 40px;
}

.library-tabs {
    display: flex;
    gap: 32px;
    border-bottom: 1px solid var(--color-border);
    margin-bottom: 32px;
}

.library-tab {
    background: transparent;
    border: none;
    color: var(--color-muted);
    padding: 14px 0;
    font-size: 18px;
    cursor: pointer;
    border-bottom: 3px solid transparent;
}

.library-tab.active {
    color: var(--color-text);
    border-bottom-color: var(--color-accent);
}

.library-tab span {
    margin-left: 8px;
    background: var(--color-border);
    color: var(--color-muted);
    padding: 2px 8px;
    border-radius: 999px;
    font-size: 14px;
}

.library-tab.active span {
    background: rgba(232,70,42,0.15);
    color: var(--color-accent);
}

.library-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 24px;
}

.library-card {
    max-width: 190px;
}

.remove-btn {
    width: 100%;
    margin-top: 10px;
    background: #991b1b;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
}

.remove-btn:hover {
    background: #b91c1c;
}

.empty-text {
    color: var(--color-muted);
    padding: 48px 0;
}
</style>

<script>
function showTab(tab) {
    const plannedTab = document.getElementById('plannedTab');
    const watchedTab = document.getElementById('watchedTab');
    const plannedBtn = document.getElementById('plannedBtn');
    const watchedBtn = document.getElementById('watchedBtn');

    if (tab === 'planned') {
        plannedTab.style.display = 'block';
        watchedTab.style.display = 'none';
        plannedBtn.classList.add('active');
        watchedBtn.classList.remove('active');
    } else {
        plannedTab.style.display = 'none';
        watchedTab.style.display = 'block';
        watchedBtn.classList.add('active');
        plannedBtn.classList.remove('active');
    }
}
</script>

@endsection