@extends('admin.master')
@section('title', 'Admin - Skippers')
@section('module', 'Skippers')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        @if (Session::has('success'))
            <div class="intro-y col-span-12 alert alert-outline-success alert-dismissible show flex items-center mb-2 bg-green-50"
                role="alert">
                <i class="fa-regular fa-circle-check text-2xl"></i>
                <span class="font-semibold ml-3">{{ Session::get('success') }}</span>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
        @if ($error = Session::get('error'))
            <div class="col-span-12 alert alert-error alert-block alert-dismissible show flex items-center mb-2 bg-red-200">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $error }}</strong>
            </div>
        @endif
        {{-- Begin search bar --}}
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a class="btn btn-primary shadow-md mr-2" href="{{ route('admin.skipper.create') }}">Add new skipper</a>
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
            <div class="hidden md:block mx-auto text-slate-500"></div>
            {{-- begin search --}}
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto">
                    <div class="w-56 relative text-slate-500">
                        <input title="Search skipper" id="search-skipper" type="search"
                            class=" tooltip hover:font-bold search_input form-control w-56 box pr-10"
                            placeholder="Search...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    </div>
                </div>
            </div>
            {{-- End search --}}
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table id="table-skipper" class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="font-semibold">#</th>
                        <th class="font-semibold">Name</th>
                        <th class="font-semibold">Phone</th>
                        <th class="font-semibold">Email</th>
                        <th class="font-semibold">Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($skippers as $skipper)
                        <tr class="intro-x">
                            <td>
                                <span>
                                    {{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $skipper->name }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $skipper->phone }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $skipper->email }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $skipper->supplier }}
                                </span>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('admin.skipper.edit', ['id' => $skipper->id]) }}"> <i
                                            data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a href="{{ route('admin.skipper.destroy', ['id' => $skipper->id]) }}"
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
                            Do you really want to delete this Skipper?
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
    <!-- END: Delete Confirmation Modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
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
            })
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
            $('#search-skipper').on('keyup', debounce(function() {
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
    <script>
        $(document).ready(function() {
            $('thead th').css('cursor', 'pointer');
        });

        function sortTable(columnIndex) {
            let table = document.getElementById('table-skipper');
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
            let headers = document.querySelectorAll('#table-skipper thead th');
            headers.forEach((header, index) => {
                header.addEventListener('click', () => {
                    sortTable(index);
                });
            });
        });
    </script>
@endsection
