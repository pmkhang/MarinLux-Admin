<!-- BEGIN: Side Menu -->
<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard.index') }}"
                class="side-menu {{ request()->is('admin/dashboard') ? 'side-menu--active' : '' }} ">
                <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                <div class="side-menu__title">
                    Dashboard
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="side-menu">
                <div class="side-menu__icon"> <i data-lucide="slack"></i> </div>
                <div class="side-menu__title">
                    Bookings
                    <div class="side-menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
                </div>
            </a>
            <ul class="">
                <li>
                    <a href="{{ route('admin.dashboard.list-booking') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                        <div class="side-menu__title"> Pending booking </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.dashboard.bookings') }}" class="side-menu">
                        <div class="side-menu__icon"> <i data-lucide="list"></i> </div>
                        <div class="side-menu__title"> Bookings list </div>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('admin.contact.index') }}"
                class="side-menu {{ request()->is('admin/contact') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="file-text"></i> </div>
                <div class="side-menu__title">
                    User Requests
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.category.index') }}"
                class="side-menu {{ request()->is('admin/category') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="layers"></i> </div>
                <div class="side-menu__title">
                    Categories
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user.index') }}"
                class="side-menu {{ request()->is('admin/user') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="users"></i> </div>
                <div class="side-menu__title">
                    Users
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.product.index') }}"
                class="side-menu {{ request()->is('admin/product') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="codepen"></i> </div>
                <div class="side-menu__title">
                    Products
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.location.index') }}"
                class="side-menu {{ request()->is('admin/location') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="globe"></i> </div>
                <div class="side-menu__title">
                    Location
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.skipper.index') }}"
                class="side-menu {{ request()->is('admin/skipper') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon"> <i data-lucide="command"></i> </div>
                <div class="side-menu__title">
                    Skippers
                    <div class="side-menu__sub-icon transform rotate-180"> <i data-lucide="chevron-left"></i>
                    </div>
                </div>
            </a>
        </li>

    </ul>
</nav>
<!-- END: Side Menu -->
