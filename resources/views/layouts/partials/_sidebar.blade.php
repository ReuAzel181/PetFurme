@can('manage-pets')
    <a href="{{ route('pets.index') }}" class="nav-link {{ request()->routeIs('pets.*') ? 'active' : '' }}">
        <span class="nav-link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paw" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                <path d="M14.7 13.5c-1.1 1.4-2.3 2.5-3.7 2.5-1.4 0-2.6-1.1-3.7-2.5-2.2-2.8-3.3-6.5-3.3-8.5 0-1.1.9-2 2-2 .8 0 1.5.4 1.8 1.1l.2.4c.3.7 1 1.2 1.8 1.2.8 0 1.5-.5 1.8-1.2l.2-.4c.3-.7 1-1.1 1.8-1.1 1.1 0 2 .9 2 2 0 2-1.1 5.7-3.3 8.5z"/>
            </svg>
        </span>
        <span class="nav-link-title">
            Pets
        </span>
    </a>
@endcan 