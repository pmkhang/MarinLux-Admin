@extends('admin.master')
@section('title', 'Admin - Users')
@section('module', 'Users')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        @if (Session::has('success'))
            <div class="intro-y col-span-12 alert alert-outline-success alert-dismissible show flex items-center mb-2 bg-green-50"
                role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    icon-name="user-plus" data-lucide="user-plus" class="lucide lucide-user-plus mr-3">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
                <span class="font-semibold">{{ Session::get('success') }}</span>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        {{-- //Thêm message error --}}
        @if ($error = Session::get('error'))
            <div class="col-span-12 alert alert-error alert-block alert-dismissible show flex items-center mb-2 bg-red-200">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $error }}</strong>
            </div>
        @endif

        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary shadow-md mr-2">Add New User</a>
            <div class="dropdown" hidden>
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        <li>
                            <a href="#" class="dropdown-item"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                                Print </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                Export to Excel </a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                Export to PDF </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of {{ $userCount }} entries</div>
            {{-- Begin search bar --}}
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto">
                    <div class="w-56 relative text-slate-500">
                        <input title="Search user" id="search-user" type="search"
                            class=" tooltip hover:font-bold search_input form-control w-56 box pr-10"
                            placeholder="Search...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
            </div>
            {{-- End search bar --}}
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table id="table-user" class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="font-semibold">#</th>
                        <th class="font-semibold text-center">Avatar</th>
                        <th class="font-semibold">Name</th>
                        <th class="font-semibold">Email</th>
                        <th class="font-semibold">Phone</th>
                        <th class="font-semibold text-center">Status</th>
                        <th class="font-semibold">Level</th>
                        <th class="font-semibold text-center">View detail</th>
                        <th class="font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="intro-x">
                            <td>
                                <span>
                                    {{ $index < 10 ? '0' . $index++ : $index++ }}
                                </span>
                            </td>
                            <td class="w-40">
                                <div class="flex items-center justify-center">
                                    <div class="w-10 h-10 image-fit zoom-in">
                                        @if (!empty($user->avatar))
                                            <img alt="Midone - HTML Admin Template" class="tooltip rounded-full"
                                                src="{{ $user->avatar }}" title="Uploaded at 29 June 2021">
                                        @else
                                            <img alt="Midone - HTML Admin Template" class="tooltip rounded-full"
                                                src="{{ asset('administrator/dist/images/avatar.jpg') }}"
                                                title="Uploaded at 29 June 2021">
                                        @endif

                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $user->name }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $user->email }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $user->phone }}
                                </span>
                            </td>
                            <td>
                                @if ($user->status == 1)
                                    <span class="text-success flex justify-center items-center gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="user-check"
                                            data-lucide="user-check" class="lucide lucide-user-check">
                                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <polyline points="17 11 19 13 23 9"></polyline>
                                        </svg>
                                        Active
                                    </span>
                                @else
                                    <span class="text-danger flex justify-center items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" icon-name="user-minus"
                                            data-lucide="user-minus" class="lucide lucide-user-minus">
                                            <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                        InActive
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($user->level == 1)
                                    <span class="text-danger font-semibold">
                                        Super Admin
                                    </span>
                                @elseif ($user->level == 2)
                                    <span class="text-success font-semibold">
                                        Admin
                                    </span>
                                @else
                                    <span class="font-semibold">
                                        Customer
                                    </span>
                                @endif

                            </td>
                            <td>
                                <a class="flex items-center justify-center mr-3"
                                    href="{{ route('admin.user.show', ['id' => $user->id]) }}"> <i
                                        data-lucide="check-square" class="w-4 h-4 mr-1"></i> Show </a>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('admin.user.edit', ['id' => $user->id]) }}">
                                        <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>
                                        Edit
                                    </a>
                                    <a class="flex items-center text-danger"
                                        href="{{ route('admin.user.destroy', ['id' => $user->id]) }}"
                                        data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <div class="intro-y mt-5 col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="paginate w-full sm:w-auto sm:mr-auto">
                <ul class="pagination">
                    <li class="page-item">
                        {{ $users->appends(request()->all())->onEachSide(1)->links() }}
                    </li>
                </ul>
            </nav>
            <form id="paginate" action="{{ route('admin.user.index') }}" method="GET">
                <select id="select" name="select" class="w-20 form-select box mt-3 sm:mt-0">
                    <option value="10" {{ $select == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $select == 20 ? 'selected' : '' }}>20</option>
                    <option value="30" {{ $select == 30 ? 'selected' : '' }}>30</option>
                    <option value="40" {{ $select == 40 ? 'selected' : '' }}>40</option>
                </select>
            </form>
        </div>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <div id="delete-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="p-5 text-center">
                        <i data-lucide="x-circle" class="w-16 h-16 text-danger mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-slate-500 mt-2">
                            Do you really want to delete these records?
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <button type="button" class="btn btn-danger w-24">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Delete Confirmation Modal -->
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
            $('#search-user').on('keyup', debounce(function() {
                let search = $(this).val().toLowerCase().trim();
                $('tbody tr').each(function() {
                    let each_row_content = $(this).text().toLowerCase();
                    if (each_row_content.includes(search)) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            }, ));
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('thead th').css('cursor', 'pointer');
        });

        function sortTable(columnIndex) {
            let table = document.getElementById('table-user');
            let rows = Array.from(table.querySelectorAll('tbody tr'));
            console.log(rows);

            rows.sort((a, b) => {
                let textA = a.querySelectorAll('td')[columnIndex].textContent.toUpperCase();
                let textB = b.querySelectorAll('td')[columnIndex].textContent.toUpperCase();
                return textA.localeCompare(textB);
            });

            if (table.querySelector('thead th.asc')) {
                rows.reverse();
                table.querySelector('thead th.asc').classList.remove('asc');
            } else {
                table.querySelector('thead th:nth-child(' + (columnIndex + 1) + ')').classList.add('asc');
            }

            let tbody = table.querySelector('tbody');
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));
        }

        document.addEventListener('DOMContentLoaded', () => {
            let headers = document.querySelectorAll('#table-user thead th');
            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    sortTable(index);
                });
            });
        });
    </script>
    <script type="text/javascript">
        let select = document.getElementById('select');
        select.addEventListener('change', function(e) {
            document.getElementById('paginate').submit();
        });
    </script>
@endsection
