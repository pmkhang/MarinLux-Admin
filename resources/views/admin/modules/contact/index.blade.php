@extends('admin.master')
@section('title', 'Admin - contacts')
@section('module', 'contacts')
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
            <div class="dropdown" hidden>
                <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i>
                    </span>
                </button>
            </div>
            <div class="hidden md:block mx-auto text-slate-500"></div>

            {{-- begin search --}}
            <div class="intro-x relative mr-3 sm:mr-6">
                <div class="search w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-slate-500">
                        <input title="Search & filter" id="search" type="search"
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
        </div>
        {{-- End search --}}

    </div>
    <!-- BEGIN: Data List -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-5">
        <table id="table-contact" class="table table-report -mt-2">
            <thead>
                <tr>
                    <th class="font-semibold">#</th>
                    <th class="font-semibold">Name</th>
                    <th class="font-semibold">Email</th>
                    <th class="font-semibold">Phone</th>
                    <th class="font-semibold">Status</th>
                    <th class="font-semibold">Created at</th>
                    <th class="font-semibold">View detail</th>
                </tr>
            </thead>
            <tbody class="search-info">
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $index < 10 ? '0' . $index++ : $index++ }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            @if ($contact->status == 1)
                                <span class="text-red-500 font-bold">
                                    Not Seen
                                </span>
                            @else
                                <span class="text-green-500 font-bold">
                                    Seen
                                </span>
                            @endif

                        </td>
                        <td>{{ $contact->created_at }}</td>
                        <td>
                            <a class="flex items-center mr-3"
                                href="{{ route('admin.contact.show', ['id' => $contact->id]) }}">
                                <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Show
                            </a>
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
                    {{ $contacts->appends(request()->all())->onEachSide(1)->links() }}
                </li>
            </ul>
        </nav>
        <form id="paginate" action="{{ route('admin.contact.index') }}" method="GET">
            <select id="select" name="select" class="w-20 form-select box mt-3 sm:mt-0">
                <option value="10" {{ $select == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $select == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ $select == 30 ? 'selected' : '' }}>30</option>
                <option value="40" {{ $select == 40 ? 'selected' : '' }}>40</option>
            </select>
        </form>
    </div>
    <!-- END: Pagination -->
    <!-- BEGIN: Delete Confirmation Modal -->
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
            $('#search-contact').on('keyup', debounce(function() {
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
            let table = document.getElementById('table-contact');
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
            let headers = document.querySelectorAll('#table-contact thead th');
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
