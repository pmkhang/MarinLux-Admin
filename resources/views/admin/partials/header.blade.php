<!-- BEGIN: Top Bar -->
<header
    class="top-bar-boxed h-[70px] md:h-[65px] z-[51] border-b border-white/[0.08] mt-12 md:mt-0 -mx-3 sm:-mx-8 md:-mx-0 px-3 md:border-b-0 relative md:fixed md:inset-x-0 md:top-0 sm:px-8 md:px-10 md:pt-10 md:bg-gradient-to-b md:from-slate-100 md:to-transparent dark:md:from-darkmode-700 ">
    <div class="h-full flex items-center">

        <!-- BEGIN: Logo -->
        <a href="{{ route('admin.dashboard.index') }}" class="logo intro-x md:flex md:items-center xl:w-[180px]">
            <img alt="Midone - HTML Admin Template" class="logo__image w-[40px]"
                src="{{ asset('administrator\dist\images\MarinLux-Logo-Icon.png') }}">
            <span class="text-white text-2xl ml-3">MarinLux</span>
        </a>
        <!-- END: Logo -->
        <!-- BEGIN: Breadcrumb -->
        <nav aria-label="breadcrumb" class="intro-x h-[45px] mr-auto">
            <ol class="breadcrumb breadcrumb-light">
                <li class="breadcrumb-item">Admin</li>
                <li class="breadcrumb-item active" aria-current="page">@yield('module')</li>
            </ol>
        </nav>
        <!-- END: Breadcrumb -->
        <!-- BEGIN: Search -->
        <div class="intro-x relative mr-3 sm:mr-6">
            <div class="search sm:block">
                <input name="searchese" id="search-input" type="search"
                    data-url="{{ route('admin.dashboard.search') }}"
                    class="search__input form-control border-transparent" placeholder="Search...">
                <i data-lucide="search" class="search__icon dark:text-slate-500"></i>
            </div>
            <div class="search-result text-slate-400">
                <div class="search-result__content">
                    <div class="mb-0 pb-0 search-box">
                        {{-- display data users here --}}
                    </div>
                </div>
            </div>
            {{-- <a class="notification notification--light sm:hidden" href="#"> <i data-lucide="search"
                    class="notification__icon dark:text-slate-500"></i> </a> --}}
        </div>
        <!-- END: Search -->
        <!-- BEGIN: Notifications -->
        <div class="intro-x dropdown mr-4 sm:mr-6">
            <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
                aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell"
                    class="notification__icon dark:text-slate-500"></i> </div>
            <div class="notification-content pt-2 dropdown-menu">
                <div class="notification-content__box dropdown-content">
                    <div class="notification-content__title">Notifications</div>
                    @if (Auth::user()->status == 1)
                        <div class="cursor-pointer relative flex items-center mt-5">
                            <div class="w-12 h-12 flex-none image-fit mr-1">
                                <img alt="Midone - HTML Admin Template" class="rounded-full"
                                    src="{{ Auth::user()->avatar }}">
                                <div
                                    class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white">
                                </div>
                            </div>
                            <div class="ml-2 overflow-hidden">
                                <div class="flex items-center">
                                    <a href="{{ route('admin.user.show', ['id' => Auth::user()->id]) }}"
                                        class="font-medium mr-5 truncate">{{ Auth::user()->name }}</a>
                                    <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">
                                        @php
                                            $time = \Carbon\Carbon::now()->format('H:i:s');
                                            $check_time = \Carbon\Carbon::now()->format('a');
                                            if ($check_time == 'am') {
                                                echo 'logged at: ' . $time . ' ' . 'am';
                                            } else {
                                                echo 'logged at: ' . $time . ' ' . 'pm';
                                            }
                                        @endphp
                                    </div>
                                </div>
                                <div class="w-full truncate text-slate-500 mt-0.5">
                                    <span class="text-success font-medium">
                                        Available
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- END: Notifications -->
        <!-- BEGIN: Account Menu -->
        <div class="intro-x dropdown w-8 h-8">
            <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110"
                role="button" aria-expanded="false" data-tw-toggle="dropdown">
                <img alt="{{ Auth::user()->name }}" src="{{ Auth::user()->avatar }}">
            </div>
            <div class="dropdown-menu w-56">
                <ul
                    class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                    <li class="p-2">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        {{-- <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ Auth::user()->level}}</div> --}}

                        <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">
                            @php
                                $level = Auth::user()->level;
                            @endphp
                            @if ($level == 1)
                                Super Admin
                            @elseif($level == 2)
                                Admin
                            @else
                                Unknown Role
                            @endif
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <a href="{{ route('admin.user.show', ['id' => Auth::user()->id]) }}"
                            class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                            Profile </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.create') }}" class="dropdown-item hover:bg-white/5"> <i
                                data-lucide="edit" class="w-4 h-4 mr-2"></i> Add Account </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock"
                                class="w-4 h-4 mr-2"></i> Reset Password </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item hover:bg-white/5"> <i data-lucide="help-circle"
                                class="w-4 h-4 mr-2"></i> Help </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5"> <i
                                data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END: Account Menu -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this,
                    args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        $(document).ready(function() {
            $('.search-result').css('display', 'none')
            $('#search-input').on('keyup', debounce(function() {
                let search = $(this).val();
                let url = $(this).data('url');
                if (search !== "") {
                    $('.search-result').show();
                    searchInput(search, url);
                } else {
                    $('.search-result').css('display', 'none')
                }
            }, 300));
            $('#search-input').on('click', function() {
                $('.search-result').hide();
            })
        });

        function searchInput(data, url) {
            jQuery.ajax({
                data: {
                    search: data
                },
                url: url,
                type: "GET",
                success: function(res) {
                    $('.search-box').html(res);
                }
            });
        }
    </script>
</header>
<!-- END: Top Bar -->
