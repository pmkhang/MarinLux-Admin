@extends('admin.master')
@section('title', 'Admin - dashboard - booking pending')
@section('module', 'dashboard - booking pending')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
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

        {{-- // add message error --}}
        @if ($error = Session::get('error'))
            <div class="col-span-12 alert alert-error alert-block alert-dismissible show flex items-center mb-2 bg-red-200">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $error }}</strong>
            </div>
        @endif
        {{-- Begin search bar --}}
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto">
                <div class="w-56 relative text-slate-500">
                    <input title="Search booking" id="search-bookings" type="search"
                        class=" tooltip hover:font-bold search_input form-control w-56 box pr-10" placeholder="Search...">
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                </div>
            </div>
        </div>
        {{-- End search bar --}}
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible mt-10">
            <table id="table-booking" class="table table-report -mt-2">
                <thead class="text-center">
                    <tr class="text-xs">
                        <th class="font-semibold">#</th>
                        <th class="font-semibold text-center">Booking code</th>
                        <th class="font-semibold">SkipID</th>
                        <th class="font-semibold">Start date</th>
                        <th class="font-semibold text-center">End date</th>
                        <th class="font-semibold">Payment</th>
                        <th class="font-semibold text-center">Booking status</th>
                        <th class="font-semibold text-center">Refund</th>
                        <th class="font-semibold text-center">Detail</th>
                    </tr>
                </thead>
                <tbody class="text-xs text-center">
                    @foreach ($bookings as $booking)
                        <tr class="intro-x">
                            <td>
                                {{ $index < 10 ? '0' . $index++ : $index++ }}
                            </td>
                            <td>
                                {{ $booking->id }}
                            </td>
                            <td>
                                @if ($booking->admin_approval_status == 1)
                                    <span class="font-bold text-center text-danger">
                                        Not Yet
                                    </span>
                                @else
                                    <span class="font-bold text-center text-success">
                                        {{ $booking->skipper_id }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $booking->startDate }}
                                </span>
                            </td>
                            <td>
                                <span class="text-center">
                                    {{ $booking->endDate }}
                                </span>
                            </td>
                            <td>
                                @if ($booking->payment_status == 1)
                                    <span class="text-yellow-500 font-bold text-center">
                                        Processing
                                    </span>
                                @elseif($booking->payment_status == 2)
                                    <span class="text-success font-bold text-center">
                                        Processed
                                    </span>
                                @else
                                    <span
                                        class=" text-xs font-medium me-2 px-2.5 py-0.5 rounded-full bg-red-900 text-slate-100">
                                        Cancel
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if ($booking->admin_approval_status == 1)
                                    <span class="text-yellow-500 font-bold text-center">
                                        Processing
                                    </span>
                                @elseif($booking->admin_approval_status == 2)
                                    <span class="text-success font-bold text-center">
                                        Processed
                                    </span>
                                @else
                                    <span
                                        class=" text-xs font-medium me-2 px-2.5 py-0.5 rounded-full bg-red-900 text-slate-100">
                                        Cancel
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($booking->refund_status == 1)
                                    <span class="text-sucess font-bold text-center">
                                        - / -
                                    </span>
                                @elseif ($booking->refund_status == 2)
                                    <span class="text-yellow-500 font-bold text-center">
                                        Processing
                                    </span>
                                @else
                                    <span class="text-success font-bold text-center">
                                        Processed
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.dashboard.booking-detail', ['id' => $booking->id]) }}"
                                    class="flex items-center text-cyan-600 justify-center mr-3 font-bold hover:text-emerald-600">
                                    <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Show
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
                        {{ $bookings->appends(request()->all())->onEachSide(1)->links() }}
                    </li>
                </ul>
            </nav>
            <form id="paginate" action="{{ route('admin.dashboard.list-booking') }}" method="GET">
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
    <!-- END: Delete Confirmation Modal -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
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
            $('#search-bookings').on('keyup', debounce(function() {
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
            let table = document.getElementById('table-booking');
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
            let headers = document.querySelectorAll('#table-booking thead th');
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
