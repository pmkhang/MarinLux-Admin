@extends('admin.master')
@section('title', 'Admin - Location')
@section('module', 'Location')

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
            <a href="{{ route('admin.location.create') }}" class="btn btn-primary shadow-md mr-2">Add New Location</a>
        </div>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">LOCATION NAME</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr class="intro-x">
                            <td>{{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}</td>
                            <td>
                                <p class="font-medium whitespace-nowrap">{{ $location->name }}</p>
                            </td>
                            <td class="table-report__action w-56">
                                <div class="flex justify-center items-center">
                                    <a class="flex items-center mr-3"
                                        href="{{ route('admin.location.edit', ['id' => $location->id]) }}"> <i
                                            data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
