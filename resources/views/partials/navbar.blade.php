

<nav class="navbar">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="navbar__logo">
        WatchList<span>+</span>
    </a>

    {{-- Center nav links --}}
    <div class="navbar__links">
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'navbar__link--active' : '' }}">
            {{ __('messages.home') }}
        </a>

        @auth
            <a href="{{ route('library') }}"
               class="{{ request()->routeIs('library') ? 'navbar__link--active' : '' }}">
                {{ __('messages.my_library') }}
            </a>
            @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                <a href="{{ route('admin.users') }}"
                   class="{{ request()->routeIs('admin.*') ? 'navbar__link--active' : '' }}">
                    Admin
                </a>
            @endif

           
            @if(auth()->user()->role && auth()->user()->role->name === 'moderator')
                <a href="{{ route('admin.logs') }}">Mod Panel</a>
            @endif
        @endauth
    </div>

    {{-- Right side: lang + auth --}}
    <div class="navbar__actions">

        {{-- Language switcher --}}
        <div class="lang-switcher">
            <a href="{{ route('lang.switch', 'en') }}"
               class="{{ app()->getLocale() === 'en' ? 'lang--active' : '' }}">EN</a>
            <span>/</span>
            <a href="{{ route('lang.switch', 'ru') }}"
               class="{{ app()->getLocale() === 'ru' ? 'lang--active' : '' }}">RU</a>
        </div>

        @guest
            <a href="{{ route('login') }}" class="btn btn--ghost">{{ __('messages.login') }}</a>
            <a href="{{ route('register') }}" class="btn btn--accent">{{ __('messages.register') }}</a>
        @endguest

        @auth
            <span class="navbar__username">{{ auth()->user()->username }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn--ghost">{{ __('messages.logout') }}</button>
            </form>
        @endauth

    </div>
</nav>

<style>
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2.5rem;
    background: rgba(10,10,15,0.9);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid var(--color-border);
    position: sticky;
    top: 0;
    z-index: 200;
}

/* Logo */
.navbar__logo {
    font-family: var(--font-display);
    font-size: 1.9rem;
    color: var(--color-text);
    text-decoration: none;
    letter-spacing: 1px;
    flex-shrink: 0;
}
.navbar__logo span { color: var(--color-accent); }

/* Nav links */
.navbar__links {
    display: flex;
    gap: 2rem;
}
.navbar__links a {
    color: var(--color-muted);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    letter-spacing: 0.3px;
    transition: color 0.2s;
    position: relative;
    padding-bottom: 2px;
}
.navbar__links a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--color-accent);
    transform: scaleX(0);
    transition: transform 0.2s;
}
.navbar__links a:hover { color: var(--color-text); }
.navbar__links a:hover::after { transform: scaleX(1); }
.navbar__links a.navbar__link--active { color: var(--color-text); }
.navbar__links a.navbar__link--active::after { transform: scaleX(1); }

/* Actions */
.navbar__actions {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-shrink: 0;
}
.navbar__username {
    font-size: 0.85rem;
    color: var(--color-muted);
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Language switcher */
.lang-switcher {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.lang-switcher a {
    color: var(--color-muted);
    text-decoration: none;
    transition: color 0.2s;
}
.lang-switcher a:hover { color: var(--color-text); }
.lang-switcher .lang--active { color: var(--color-accent); }
.lang-switcher span { color: var(--color-border); }
</style>
