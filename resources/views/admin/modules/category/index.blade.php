@extends('admin.master')
@section('title', 'Admin - Category')
@section('module', 'Category')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        @if (Session::has('success'))
            <div class="mt-2 intro-y col-span-12 alert alert-outline-success alert-dismissible show flex items-center mb-2 bg-green-50"
                role="alert">
                <i class="fa-regular fa-circle-check text-2xl"></i>
                <span class="font-semibold ml-2 text-lg">{{ Session::get('success') }}</span>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="mt-2 intro-y col-span-12 alert alert-outline-danger alert-dismissible show flex items-center mb-2 bg-red-50"
                role="alert">
                <i class="fa-regular fa-circle-xmark"></i>
                <span class="font-semibold ml-2 text-lg">{{ Session::get('error') }}</span>
                <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary shadow-md mr-2">Add New Category</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">CATEGORY NAME</th>
                        <th class="text-center whitespace-nowrap">STATUS</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="intro-x">
                            <td>{{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}</td>
                            <td>
                                <p class="font-medium whitespace-nowrap">{{ $category->name }}</p>
                            </td>
                            <td class="w-40">
                                {!! $category->status == 1
                                    ? ' <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>Active</div>'
                                    : ' <div class="flex items-center justify-center text-danger"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i>Inactive</div>' !!}
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('admin.category.edit', ['id' => $category->id]) }}"> <i
                                            data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>

                                    <a href="{{ route('admin.category.destroy', ['id' => $category->id]) }}"
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
                            Do you really want to delete this Category?
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.delete-link').on('click', function(e) {
                e.preventDefault();
                let url = $(this).attr('href');
                $('#delete-confirmation-modal-delete-button').attr('href', url);
            })
        });
    </script>
    <!-- END: Delete Confirmation Modal -->
@endsection
