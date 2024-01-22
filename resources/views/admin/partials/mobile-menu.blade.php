<!-- BEGIN: Mobile Menu -->
<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="#" class="flex mr-auto">
            <img alt="Midone - HTML Admin Template" class="w-6" src="{{ asset('administrator/dist/images/logo.svg') }}">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle"
                class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        <ul class="scrollable__content py-2 flex flex-col gap-3 mt-3">
            <li>
                <a href="{{ route('admin.dashboard.index') }}" class="menu menu--active">
                    <div class="menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="menu__title"> Dashboard <i data-lucide="chevron-left"
                            class="menu__sub-icon transform rotate-180"></i> </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.category.index') }}" class="menu menu--active">
                    <div class="menu__icon"> <i data-lucide="layers"></i> </div>
                    <div class="menu__title"> Categories <i data-lucide="chevron-left"
                            class="menu__sub-icon transform rotate-180"></i> </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.product.index') }}" class="menu menu--active">
                    <div class="menu__icon"> <i data-lucide="codepen"></i> </div>
                    <div class="menu__title"> Products <i data-lucide="chevron-left"
                            class="menu__sub-icon transform rotate-180"></i> </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.user.index') }}" class="menu menu--active">
                    <div class="menu__icon"> <i data-lucide="users"></i> </div>
                    <div class="menu__title"> Users <i data-lucide="chevron-left"
                            class="menu__sub-icon transform rotate-180"></i> </div>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- END: Mobile Menu -->
