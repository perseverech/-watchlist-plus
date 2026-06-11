<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, Review $review): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, Review $review): bool
    {
        return false;
    }
    public function delete(User $user, Review $review): bool
    {
        return $user->id === $review->user_id || $user->role === 'moderator';
    }

    public function restore(User $user, Review $review): bool
    {
        return false;
    }
    public function forceDelete(User $user, Review $review): bool
    {
        return false;
    }
}