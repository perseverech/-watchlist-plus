

<div class="review-form-wrap" id="review-form-wrap">
    <h3 class="review-form__title">{{ __('messages.write_review') }}</h3>

    <div class="review-form">

        {{-- 1–10 rating picker --}}
        <div class="rating-picker">
            <span class="rating-picker__label">Rating:</span>
            <div class="rating-picker__buttons" id="rating-buttons">
                @for($i = 1; $i <= 10; $i++)
                    <button
                        type="button"
                        class="rating-btn"
                        data-value="{{ $i }}"
                        onclick="setRating({{ $i }})"
                        title="{{ $i }}/10"
                    >{{ $i }}</button>
                @endfor
            </div>
            <span class="rating-picker__selected" id="rating-display">—</span>
        </div>
        <input type="hidden" id="review-rating" value="">

        {{-- Review text --}}
        <div class="review-textarea-wrap">
            <textarea
                id="review-content"
                class="review-textarea"
                placeholder="{{ __('messages.review_placeholder') }}"
                rows="4"
                maxlength="1000"
            ></textarea>
            <div class="char-counter">
                <span id="char-count">0</span>/1000
            </div>
        </div>

        {{-- Error message --}}
        <p class="review-error" id="review-error" style="display:none"></p>

        {{-- Submit button --}}
        <button
            type="button"
            class="btn btn--accent review-submit-btn"
            id="review-submit-btn"
            onclick="submitReview({{ $mediaId }})"
        >
            {{ __('messages.submit') }} Review
        </button>

    </div>
</div>

<style>
.review-form-wrap {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 1.6rem;
    margin-bottom: 2rem;
}
.review-form__title {
    font-family: var(--font-display);
    font-size: 1.4rem;
    letter-spacing: 0.5px;
    margin-bottom: 1.2rem;
}
.review-form { display: flex; flex-direction: column; gap: 1.1rem; }

/* Rating picker */
.rating-picker { display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; }
.rating-picker__label { font-size: 0.82rem; color: var(--color-muted); font-weight: 500; white-space: nowrap; }
.rating-picker__buttons { display: flex; gap: 0.35rem; flex-wrap: wrap; }
.rating-btn {
    width: 34px;
    height: 34px;
    border-radius: 6px;
    border: 1px solid var(--color-border);
    background: var(--color-bg);
    color: var(--color-muted);
    font-family: var(--font-body);
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.rating-btn:hover { border-color: var(--color-accent2); color: var(--color-accent2); }
.rating-btn.active { border-color: var(--color-accent2); background: rgba(245,166,35,0.12); color: var(--color-accent2); }
.rating-picker__selected { font-size: 0.9rem; color: var(--color-accent2); font-weight: 600; min-width: 40px; }

/* Textarea */
.review-textarea-wrap { position: relative; }
.review-textarea {
    width: 100%;
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    padding: 0.8rem 1rem;
    color: var(--color-text);
    font-family: var(--font-body);
    font-size: 0.92rem;
    resize: vertical;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    line-height: 1.55;
}
.review-textarea:focus {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px rgba(232,70,42,0.08);
}
.review-textarea::placeholder { color: var(--color-muted); }
.char-counter {
    text-align: right;
    font-size: 0.72rem;
    color: var(--color-muted);
    margin-top: 0.3rem;
}

.review-error { color: #e07070; font-size: 0.85rem; }
.review-submit-btn { align-self: flex-start; padding: 0.65rem 1.6rem; }
.review-submit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
</style>

<script>
let selectedRating = null;

function setRating(value) {
    selectedRating = value;
    document.getElementById('review-rating').value  = value;
    document.getElementById('rating-display').textContent = `${value}/10`;
    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.classList.toggle('active', parseInt(btn.dataset.value) === value);
    });
}

// Character counter
document.getElementById('review-content').addEventListener('input', function() {
    document.getElementById('char-count').textContent = this.value.length;
});


async function submitReview(mediaId) {
    const ratingInput  = document.getElementById('review-rating');
    const contentInput = document.getElementById('review-content');
    const submitBtn    = document.getElementById('review-submit-btn');
    const errorEl      = document.getElementById('review-error');

    // Client-side validation
    if (!ratingInput.value) {
        errorEl.textContent    = 'Please select a rating (1–10).';
        errorEl.style.display  = 'block';
        return;
    }
    if (contentInput.value.trim().length < 10) {
        errorEl.textContent    = 'Review must be at least 10 characters.';
        errorEl.style.display  = 'block';
        return;
    }

    errorEl.style.display  = 'none';
    submitBtn.disabled     = true;
    submitBtn.textContent  = 'Submitting...';

    try {
        const response = await fetch('/reviews', {
            method: 'POST',
            headers: {
                'Content-Type':     'application/json',
                'X-CSRF-TOKEN':     document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept':           'application/json',
            },
            body: JSON.stringify({
                media_id: mediaId,
                rating:   ratingInput.value,
                content:  contentInput.value.trim(),
            })
        });

        // Handle server validation errors
        if (response.status === 422) {
            const err = await response.json();
            errorEl.textContent   = Object.values(err.errors).flat().join(' ');
            errorEl.style.display = 'block';
            return;
        }
        if (!response.ok) throw new Error('Submit failed');

        const review = await response.json();

        // Prepend the new card to the reviews list without reloading
        const noMsg = document.getElementById('no-reviews-msg');
        if (noMsg) noMsg.remove();

        document.getElementById('reviews-list').insertAdjacentHTML('afterbegin', `
            <div class="review-card" id="review-${review.id}">
                <div class="review-card__header">
                    <div class="review-card__user">
                        <span class="review-card__avatar">${(review.user?.username || 'You')[0].toUpperCase()}</span>
                        <div>
                            <strong>${review.user?.username || 'You'}</strong>
                            <span class="review-card__date">Just now</span>
                        </div>
                    </div>
                    <span class="review-card__rating">⭐ ${review.rating}/10</span>
                </div>
                <p class="review-card__content">${review.content}</p>
                <div class="review-card__actions">
                    <button class="review-card__delete" onclick="deleteReview(${review.id})">Delete</button>
                </div>
            </div>
        `);

        // Reset form
        ratingInput.value                               = '';
        contentInput.value                              = '';
        selectedRating                                  = null;
        document.getElementById('rating-display').textContent = '—';
        document.getElementById('char-count').textContent     = '0';
        document.querySelectorAll('.rating-btn').forEach(b => b.classList.remove('active'));

    } catch (err) {
        errorEl.textContent   = 'Something went wrong. Please try again.';
        errorEl.style.display = 'block';
        console.error('Review submit error:', err);
    } finally {
        submitBtn.disabled    = false;
        submitBtn.textContent = '{{ __("messages.submit") }} Review';
    }
}
</script>

