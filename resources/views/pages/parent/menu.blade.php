{{-- My Children --}}
<li class="nav-item">

    <a
        href="{{ route('my_children') }}"
        class="nav-link {{ Route::currentRouteName() == 'my_children' ? 'active' : '' }}"
    >

        <i class="icon-users4"></i>

        <span>
            My Children
        </span>

    </a>

</li>


{{-- Notifications --}}
<li class="nav-item">

    <a
        href="{{ route('parent.notifications') }}"
        class="nav-link {{ Route::currentRouteName() == 'parent.notifications' ? 'active' : '' }}"
    >

        <i class="icon-bell2"></i>

        <span>
            Notifications
        </span>

    </a>

</li>