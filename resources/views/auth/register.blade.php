
@extends('layouts.app')
@section('title', __('messages.register'))

@section('content')
<div class="auth-page">
    <div class="auth-card">

        <div class="auth-card__header">
            <h1>{{ __('messages.register') }}</h1>
            <p>Create an account and start tracking.</p>
        </div>

        @if($errors->any())
            <div class="auth-errors">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="name">Username</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="cinephile42"
                    required
                    autocomplete="username"
                >
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Min. 8 characters"
                    required
                    autocomplete="new-password"
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn btn--accent btn--full">
                {{ __('messages.register') }}
            </button>
        </form>

        <p class="auth-card__footer">
            Already have an account?
            <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
        </p>

    </div>
</div>
@endsection

@push('styles')
<style>
.auth-page {
    min-height: calc(100vh - 70px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: radial-gradient(ellipse at 50% 0%, rgba(232,70,42,0.08) 0%, transparent 60%);
}
.auth-card {
    width: 100%;
    max-width: 420px;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 16px;
    padding: 2.5rem;
}
.auth-card__header { margin-bottom: 1.8rem; }
.auth-card__header h1 {
    font-family: var(--font-display);
    font-size: 2.6rem;
    letter-spacing: 1px;
    line-height: 1;
}
.auth-card__header p { color: var(--color-muted); font-size: 0.9rem; margin-top: 0.4rem; }
.auth-errors {
    background: rgba(232,70,42,0.08);
    border: 1px solid rgba(232,70,42,0.25);
    border-radius: 8px;
    padding: 0.8rem 1rem;
    margin-bottom: 1.2rem;
    color: #e07070;
    font-size: 0.85rem;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}
.auth-form { display: flex; flex-direction: column; gap: 1.2rem; }
.form-group { display: flex; flex-direction: column; gap: 0.4rem; }
.form-group label {
    font-size: 0.82rem;
    color: var(--color-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.form-group input {
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: var(--color-text);
    font-family: var(--font-body);
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-group input:focus {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px rgba(232,70,42,0.1);
}
.form-group input::placeholder { color: var(--color-muted); }
.auth-card__footer {
    margin-top: 1.5rem;
    text-align: center;
    font-size: 0.85rem;
    color: var(--color-muted);
}
.auth-card__footer a { color: var(--color-accent); text-decoration: none; font-weight: 500; }
.auth-card__footer a:hover { text-decoration: underline; }
</style>
@endpush

