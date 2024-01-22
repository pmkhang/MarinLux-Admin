@extends('admin.master')
@section('title', 'Admin - products')
@section('module', 'products')
@section('content')

    <div class="grid grid-cols-12 gap-6 mt-6">
        @if (Session::has('success'))
            <div class="intro-y col-span-12 alert alert-outline-success alert-dismissible show flex items-center mb-2 bg-green-50"
                role="alert">
                <i class="fa-regular fa-circle-check text-2xl mr-3"></i>
                <span class="font-semibold">{{ Session::get('success') }}</span>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-error alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a class="btn btn-primary shadow-md mr-2" href="{{ route('admin.product.create') }}">Add New Product</a>
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
            <div class="result md:block mx-auto text-slate-500">
                {{-- display results total --}}
            </div>
            {{-- begin search --}}
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <input title="Search & filter yacht" id="search" type="search"
                            class=" tooltip hover:font-bold search_input form-control w-56 box pr-10"
                            placeholder="Search..." data-url="{{ route('admin.product.search') }}">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
                <div class="mt-2 absolute">
                    <div id="box-data" class="box-data form-control w-56 box pr-10">
                        {{-- display data --}}
                    </div>
                </div>
            </div>
            {{-- End search --}}
        </div>
    </div>
    <!-- BEGIN: Data List -->

    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-10">
        <table id="table-yacht" class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="font-semibold">#</th>
                    <th class="font-semibold">Yacht name</th>
                    <th class="font-semibold">Location</th>
                    <th class="font-semibold">Category</th>
                    <th class="font-semibold">Price per day</th>
                    <th class="font-semibold text-center">Status</th>
                    <th class="font-semibold text-center">View detail</th>
                    <th class="font-semibold text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="search-info">
                @foreach ($yachts as $yacht)
                    <tr class="intro-x">
                        <td>
                            {{-- {{ $index < 10 ? '0' . $index++ : $index++ }} --}}
                            <span>
                                {{ $index < 10 ? '0' . $index++ : $index++ }}
                            </span>
                        </td>
                        <td>
                            <span class="text-center">
                                {{ $yacht->name }}
                            </span>
                        </td>
                        <td>
                            <span class="text-center">
                                {{ $yacht->location->name }}
                            </span>
                        </td>
                        <td>
                            <span class="text-center">
                                {{ $yacht->category->name }}
                            </span>
                        </td>
                        <td>
                            <span class="text-center">
                                ${{ $yacht->price_per_day }}
                            </span>
                        </td>
                        <td>
                            @if ($yacht->status == 1)
                                <span class="text-success flex justify-center items-center gap-4">
                                    Active
                                </span>
                            @elseif($yacht->status == 2)
                                <span class="text-success flex justify-center items-center gap-2">
                                    For rent
                                </span>
                            @elseif($yacht->status == 3)
                                <span class="text-danger flex justify-center items-center gap-2">
                                    Sold
                                </span>
                            @else
                                <span class="text-danger flex justify-center items-center gap-2">
                                    Delete
                                </span>
                            @endif
                        </td>
                        <td>
                            <a class="flex items-center justify-center mr-3"
                                href="{{ route('admin.product.show', ['id' => $yacht->id]) }}"> <i
                                    data-lucide="check-square" class="w-4 h-4 mr-1"></i> Show </a>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">

                                <a class="flex items-center mr-3"
                                    href="{{ route('admin.product.edit', ['id' => $yacht->id]) }}"> <i
                                        data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                <a href="{{ route('admin.product.destroy', ['id' => $yacht->id]) }}"
                                    class="delete-link flex items-center text-danger" data-tw-toggle="modal"
                                    data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2"
                                        class="w-4 h-4 mr-1"></i>
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
                    {{ $yachts->appends(request()->all())->onEachSide(1)->links() }}
                </li>
            </ul>
        </nav>
        <form id="paginate" action="{{ route('admin.product.index') }}" method="GET">
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
                            Do you really want to delete this Yacht?
                            <br>
                            This process cannot be undone.
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-tw-dismiss="modal"
                            class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                        <a href="" id="delete-confirmation-modal-delete-button"
                            class="btn btn-danger w-24">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-link').on('click', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $('#delete-confirmation-modal-delete-button').attr('href', url);
            });
        });

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
            $('#data').html('');
            $("#search").on('keyup', debounce(function(event) {
                let search = $(this).val();
                let url = $(this).data('url');

                if (search == "") {
                    $('#box-data').hide();
                } else {
                    show(search, url);
                    $('#box-data').slideDown();
                }
            }, 500));

            $("#search").on('click', function() {
                $('#box-data').hide();
            });

            function show(search, url) {
                jQuery.ajax({
                    url: url,
                    data: {
                        search: search
                    },
                    type: "GET",
                    success: function(response) {
                        $('#box-data').html(response);
                    }
                });
            }
        });
        $(document).ready(function() {
            $('#search').on('keyup', debounce(function() {
                let search = $(this).val().toLowerCase().trim();
                $('tbody tr').each(function() {
                    let each_row_content = $(this).text().toLowerCase();
                    if (each_row_content.includes(search)) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            }));
        });
    </script>
    <!-- END: Delete Confirmation Modal -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('thead th').css('cursor', 'pointer');
        });

        function sortTable(columnIndex) {
            let table = document.getElementById('table-yacht');
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
            let headers = document.querySelectorAll('#table-yacht thead th');
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
