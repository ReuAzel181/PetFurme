<!-- Remove or comment out the customers section in your navigation -->
<!-- It might look something like this: -->
<!--
<li class="nav-item">
    <a class="nav-link" href="{{ route('customers.index') }}">
        <span class="nav-link-icon">...</span>
        <span class="nav-link-title">Customers</span>
    </a>
</li>
-->

<!-- Add this to your sidebar navigation -->
<li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('users.index') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
            </svg>
        </span>
        <span class="nav-link-title">
            Users
        </span>
    </a>
</li>