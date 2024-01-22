@extends('admin.master')
@section('title', 'Admin - User')

@section('module', 'User')

@section('content')
    @if (Session::has('success'))
        <div class="mt-5 intro-y col-span-12 alert alert-outline-success alert-dismissible show flex items-center mb-2 bg-green-50"
            role="alert">
            <i class="fa-regular fa-circle-check text-2xl"></i>
            <span class="font-semibold ml-2 text-lg">{{ Session::get('success') }}</span>
            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
    <div class="intro-y p-3 box  flex items-start mt-5">

        <div class="flex items-center justify-center gap-3">
            <img alt="" class="rounded-md w-[200px] h-[200px] object-cover" src="{{ $user->avatar }}">
        </div>
        <div class="text-left flex-1 ml-6">
            <div class="font-semibold mb-6 text-xl flex flex-col gap-3">
                <p>Name: {{ $user->name }}</p>
                <p>Email: {{ $user->email }}</p>
                <p>Phone: {{ $user->phone }}</p>
                <p>Level
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
                </p>
            </div>
        </div>
        <div class="text-right flex items-center gap-3">
            <a class="btn btn-secondary shadow-md" href="{{ route('admin.booking.index', ['id' => $user->id]) }}">
                Add a new booking for user
            </a>
            <a class="btn btn-primary shadow-md" href="{{ route('admin.user.edit', ['id' => $user->id]) }}">
                <i data-lucide="check-square" class="mr-2"></i> Edit
            </a>
        </div>
    </div>
    <div class="intro-y p-3 px-5 mt-5 rounded-md">
        <h2 class="intro-x text-2xl font-bold">User's booking</h2>
        <table class="table table-report mt-3">
            <thead>
                <tr>
                    <th class="font-medium text-center">#</th>
                    <th class="font-medium text-center">Booking code</th>
                    <th class="font-medium text-center">Start Date</th>
                    <th class="font-medium text-center">End Date</th>
                    <th class="font-medium text-center">Payment Status</th>
                    <th class="font-medium text-center">Admin Approval Status</th>
                    <th class="font-medium text-center">Refund Status</th>
                    <th class="font-medium text-center">Created At</th>
                    <th class="font-medium text-center">View detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr class="intro-x">
                        <td class="font-medium text-center">
                            {{ $loop->iteration < 10 ? '0' . $loop->iteration : $loop->iteration }}</td>
                        <td class="font-medium text-center">{{ $booking->id }}</td>
                        <td class="font-medium text-center text-blue-700">
                            {{ \Carbon\Carbon::parse($booking->startDate)->format('M-d-Y') }}</td>
                        <td class="font-medium text-center text-blue-700">
                            {{ \Carbon\Carbon::parse($booking->endDate)->format('M-d-Y') }}</td>
                        <td class="font-medium text-center">
                            @if ($booking->payment_status == 1)
                                <span class="text-yellow-500 font-bold">Processing</span>
                            @elseif($booking->payment_status == 2)
                                <span class="text-green-500 font-bold">Processed</span>
                            @else
                                <span class="text-red-500 font-bold">Canceled</span>
                            @endif
                        </td>
                        <td class="font-medium text-center">
                            @if ($booking->admin_approval_status == 1)
                                <span class="text-yellow-500 font-bold">Processing</span>
                            @elseif($booking->admin_approval_status == 2)
                                <span class="text-green-500 font-bold">Processed</span>
                            @else
                                <span class="text-red-500 font-bold">Canceled</span>
                            @endif
                        </td>
                        <td class="font-medium text-center">
                            @if ($booking->refund_status == 1)
                                <span>No process</span>
                            @elseif($booking->refund_status == 2)
                                <span class="text-yellow-500 font-bold">Processing</span>
                            @else
                                <span class="text-green-500 font-bold">Processed</span>
                            @endif
                        </td>
                        </td>
                        <td class="font-medium text-center">
                            {{ \Carbon\Carbon::parse($booking->created_at)->addHours(7)->format('M-d-Y - H:i') }}</td>
                        <td> <a class="flex items-center justify-center"
                                href="{{ route('admin.dashboard.booking-detail', ['id' => $booking->id]) }}">
                                <i data-lucide="check-square" class="mr-2"></i>
                                Show Booking
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
