

<div class="review-card" id="review-{{ $review->id }}">

    <div class="review-card__header">
        <div class="review-card__user">
            {{-- Avatar: first letter of username --}}
            <span class="review-card__avatar">
                {{ strtoupper(substr($review->user->username ?? '?', 0, 1)) }}
            </span>
            <div>
                <strong>{{ $review->user->username ?? 'Unknown' }}</strong>
                <span class="review-card__date">
                    {{-- ⚠️ DEPENDS ON AL'ZHANA: $review->created_at must be a Carbon date --}}
                    {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                </span>
            </div>
        </div>
        <span class="review-card__rating">⭐ {{ $review->rating }}/10</span>
    </div>

    <p class="review-card__content">{{ $review->content }}</p>

    {{-- Delete button — only shown to the review's own author --}}
    @auth
        @if(auth()->id() === $review->user_id)
            <div class="review-card__actions">
                <button
                    class="review-card__delete"
                    onclick="deleteReview({{ $review->id }})"
                >
                    Delete
                </button>
            </div>
        @endif

        @if(auth()->id() !== $review->user_id &&
            in_array(auth()->user()->role->name ?? '', ['moderator', 'admin']))
            <div class="review-card__actions">
                <button
                    class="review-card__delete"
                    onclick="deleteReview({{ $review->id }})"
                >
                    Remove (Mod)
                </button>
            </div>
        @endif
    @endauth

</div>

<style>
.review-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 10px;
    padding: 1.2rem 1.4rem;
    margin-bottom: 1rem;
    transition: border-color 0.2s;
}
.review-card:hover { border-color: rgba(232,70,42,0.15); }

.review-card__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.9rem;
}
.review-card__user { display: flex; align-items: center; gap: 0.75rem; }
.review-card__avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--color-accent);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.85rem;
    flex-shrink: 0;
}
.review-card__user strong { font-size: 0.9rem; display: block; line-height: 1.3; }
.review-card__date { font-size: 0.75rem; color: var(--color-muted); }
.review-card__rating { font-size: 0.88rem; color: var(--color-accent2); font-weight: 600; flex-shrink: 0; }
.review-card__content {
    color: var(--color-muted);
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 0.6rem;
}
.review-card__actions { display: flex; justify-content: flex-end; }
.review-card__delete {
    background: transparent;
    border: none;
    color: #e07070;
    font-size: 0.78rem;
    cursor: pointer;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    font-family: var(--font-body);
    transition: background 0.2s;
}
.review-card__delete:hover { background: rgba(224,112,112,0.08); }
</style>

<script>
async function deleteReview(reviewId) {
    if (!confirm('Delete this review?')) return;

    try {
        const response = await fetch(`/reviews/${reviewId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            }
        });

        const data = await response.json();

        if (data.success) {
            const card = document.getElementById(`review-${reviewId}`);
            if (card) {
                card.style.transition = 'opacity 0.3s, transform 0.3s';
                card.style.opacity    = '0';
                card.style.transform  = 'translateY(-8px)';
                setTimeout(() => card.remove(), 300);
            }
        }

    } catch (err) {
        alert('Could not delete review. Please try again.');
        console.error('Delete review error:', err);
    }
}
</script>

