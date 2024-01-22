@extends('admin.master')
@section('title', 'booking detail')
@section('module', 'booking-detail')
@section('content')
    <div class="intro-y box mt-5 mb-32">
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
        <div class="flex flex-col px-14 pt-14 text-center sm:text-left">
            <h2 class="font-semibold text-primary text-4xl">BOOKING DETAIL</h2>
            <p class="text-xl text-primary font-medium mt-3">Booking code: {{ $booking->id }}</p>
            <p class="mt-1 text-lg text-primary font-medium">Created: {{ $booking->created_at }}</p>
        </div>
        <div class="flex tl:flex-col border-b-2">
            <div class="flex-1 px-10 my-10 ">
                <table class="table ">
                    <thead>
                        <tr>
                            <th class="border-b-2 whitespace-nowrap text-3xl">User info</th>
                            <th class="border-b-2 text-right whitespace-nowrap"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Name:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $booking->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Email:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $booking->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Phone:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $booking->user->phone }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex-1 px-10 my-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="border-b-2 whitespace-nowrap text-3xl">Yacht info</th>
                            <th class="border-b-2 text-right whitespace-nowrap"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Yacht code:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $booking->yacht_id }}</td>
                        </tr>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Name:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $booking->yacht->name }}</td>
                        </tr>
                        <tr>
                            <td class="border-b">
                                <div class="font-medium whitespace-nowrap">Category:</div>
                            </td>
                            <td class="text-right border-b w-full font-bold">{{ $category->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex tl:flex-col">
            <div class="flex-1 px-10 my-10">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-b-2 whitespace-nowrap text-3xl">Booking status</th>
                                <th class="border-b-2 text-right whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">Start date:</div>
                                </td>
                                <td class="text-right border-b w-full">{{ $booking->startDate }}</td>
                            </tr>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">End date:</div>
                                </td>
                                <td class="text-right border-b w-full">{{ $booking->endDate }}</td>
                            </tr>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">Quests quantity:</div>
                                </td>
                                <td class="text-right border-b w-full">{{ $booking->guests }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Location: </div>
                                </td>
                                <td class="text-right w-full">{{ $location->name }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Skipper: </div>
                                </td>
                                <td class="text-right w-full">{{ $skipperName }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Booking status: </div>
                                </td>
                                @if ($booking->admin_approval_status == 1)
                                    <td class="text-right w-full text-yellow-500 font-bold">Processing</td>
                                @elseif ($booking->admin_approval_status == 2)
                                    <td class="text-right w-full text-green-500 font-bold">Processed</td>
                                @elseif ($booking->admin_approval_status == 3)
                                    <td class="text-right w-full text-red-500 font-bold">Cancel</td>
                                @endif
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Payment status: </div>
                                </td>
                                @if ($booking->payment_status == 1)
                                    <td class="text-right w-full text-yellow-500 font-bold">Processing</td>
                                @elseif ($booking->payment_status == 2)
                                    <td class="text-right w-full text-green-500 font-bold">Processed</td>
                                @elseif ($booking->payment_status == 3)
                                    <td class="text-right w-full text-red-500 font-bold">Cancel</td>
                                @endif
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Refund status: </div>
                                </td>
                                @if ($booking->refund_status == 1)
                                    <td class="text-right w-full  font-bold">No process</td>
                                @elseif ($booking->refund_status == 2)
                                    <td class="text-right w-full text-yellow-500 font-bold">Processing</td>
                                @elseif ($booking->refund_status == 3)
                                    <td class="text-right w-full text-green-500 font-bold">Processed</td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex-1 px-10 my-10">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border-b-2 whitespace-nowrap text-3xl">Fee detail</th>
                                <th class="border-b-2 text-right whitespace-nowrap">PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">Charter total</div>
                                </td>
                                <td class="text-right border-b w-full font-bold">${{ $booking->booking_fee->charter }}</td>
                            </tr>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">Service</div>
                                </td>
                                <td class="text-right border-b w-full font-bold">${{ $booking->booking_fee->service }}</td>
                            </tr>
                            <tr>
                                <td class="border-b">
                                    <div class="font-medium whitespace-nowrap">Tax</div>
                                </td>
                                <td class="text-right border-b w-full font-bold">${{ $booking->booking_fee->tax }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Insurance</div>
                                </td>
                                <td class="text-right w-full font-bold">${{ $booking->booking_fee->insurance }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Total</div>
                                </td>
                                <td class="text-right w-full font-bold">${{ $booking->booking_fee->total }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Deposit</div>
                                </td>
                                <td class="text-right w-full font-bold">${{ $booking->booking_fee->deposit }}</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium whitespace-nowrap">Refund amount</div>
                                </td>
                                <td class="text-right w-full font-bold">${{ $booking->booking_fee->refund_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($crewMembers > 0)
            <div class="flex tl:flex-col">
                <div class="flex-1 px-10 my-10">
                    <div class="">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="border-b-2 whitespace-nowrap font-bold text-3xl">Cew members</th>
                                    <th class="border-b-2 whitespace-nowrap font-bold">Name</th>
                                    <th class="border-b-2 whitespace-nowrap font-bold">ID number</th>
                                    <th class="border-b-2 whitespace-nowrap font-bold">Email</th>
                                    <th class="border-b-2 whitespace-nowrap font-bold">Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking->crew_members as $crewMember)
                                    <tr>
                                        <td class="border-b">
                                            {{ $index < 10 ? '0' . $index++ : $index++ }}</td>
                                        <td class="border-b">{{ $crewMember->name }}</td>
                                        <td class="border-b">{{ $crewMember->identify_number }}</td>
                                        <td class="border-b">{{ $crewMember->email }}</td>
                                        <td class="border-b">{{ $crewMember->phone }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="px-14 pb-12 my-10 flex flex-col">
            {!! $booking->refund_status == 3 ? '' : '<h3 class="whitespace-nowrap text-3xl font-bold">Admin action</h3>' !!}
            @if ($booking->admin_approval_status != 3 && $booking->refund_status != 3)
                @if ($crewMembers <= 0)
                    <a href="{{ route('admin.dashboard.addCrewMember', ['id' => $booking->id]) }}"
                        class="btn btn-primary mr-1 my-2">Add crew members</a>
                @endif
                <form method="POST" action="{{ route('admin.dashboard.adminAction', ['id' => $booking->id]) }}">
                    @csrf
                    <div class="flex items-center gap-4 mt-5">
                        @if ($booking->payment_status == 1)
                            <div class="w-full">
                                <label class="form-label font-semibold">Payment Status</label>
                                <select name="payment_status" class="tom-select w-full">
                                    <option value=""></option>
                                    <option value="2">Processed</option>
                                    <option value="3">Cancel payment</option>
                                </select>
                            </div>
                        @endif
                        <div class="w-full">
                            <label class="form-label font-semibold">Skipper</label>
                            <select name="skipper_id" class="tom-select w-full">
                                <option value=""></option>
                                @foreach ($skippers as $skipper)
                                    <option value="{{ $skipper->id }}"
                                        {{ old('skipper_id', $skipper->id) == $booking->skipper_id ? 'selected' : '' }}>
                                        {{ $skipper->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full">
                            <label class="form-label font-semibold">Refund</label>
                            <select name="refund_status" class="tom-select w-full">
                                <option value=""></option>
                                <option value="2"
                                    {{ old('refund_status', $booking->refund_status) == 2 ? 'selected' : '' }}>Processing
                                </option>
                                <option value="3"
                                    {{ old('refund_status', $booking->refund_status) == 3 ? 'selected' : '' }}>Processed
                                </option>
                            </select>
                        </div>
                        <div class="w-full">
                            <label class="form-label font-semibold">Booking Status</label>
                            <select name="admin_approval_status" class="tom-select w-full">
                                <option value="2"
                                    {{ old('admin_approval_status', $booking->admin_approval_status) == 2 ? 'selected' : '' }}>
                                    Processed</option>
                                <option value="3"
                                    {{ old('admin_approval_status', $booking->admin_approval_status) == 3 ? 'selected' : '' }}>
                                    Cancel booking</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-end">
                        <button class="btn btn-primary w-32 mt-5">Approve</button>
                    </div>
                </form>
            @endif
            @if ($booking->refund_status == 2 && $booking->admin_approval_status == 3)
                <form method="POST" action="{{ route('admin.dashboard.adminAction', ['id' => $booking->id]) }}">
                    @csrf
                    <div class="flex items-center gap-4 mt-5">
                        <div class="w-full">
                            <label class="form-label font-semibold">Refund</label>
                            <select name="refund_status" class="tom-select w-full">
                                <option value=""></option>
                                <option value="3">Processed</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-end">
                        <button class="btn btn-primary w-32 mt-5">Approve</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection
