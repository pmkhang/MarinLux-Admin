@extends('admin.master')
@section('title', 'Admin - dashboard - add crew members')
@section('module', 'dashboard - add crew members')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="intro-x col-span-12">
            <form class="w-full flex flex-col " action="{{ route('admin.dashboard.createCrewMember', ['id' => $id]) }}"
                method="POST">
                @csrf
                @for ($i = 1; $i <= $guests; $i++)
                    <div class="flex flex-col gap-2 px-2 mb-6">
                        <h3 class="text-lg font-bold">Crew {{ $i }}: </h3>
                        <div class="intro-x w-full flex items-center gap-4">
                            <div class="w-full relative flex flex-col">
                                <label for="name{{ $i }}" class="form-label p-1 font-semibold">Name: <i
                                        class="text-red-500 text-xs">*</i></label>
                                <input id="name{{ $i }}" value="{{ old('name.' . ($i - 1)) }}" name="name[]"
                                    type="text" class="form-control">
                                @if ($errors->has('name.' . ($i - 1)))
                                    <span class="text-red-500 text-sm m-2 absolute top-[68px]">
                                        {{ str_replace(':crew', $i, $errors->first('name.' . ($i - 1))) }}
                                    </span>
                                @endif
                            </div>
                            <div class="w-full relative flex flex-col">
                                <label for="id-number{{ $i }}" class="form-label p-1 font-semibold">ID number: <i
                                        class="text-red-500 text-xs">*</i></label>
                                <input id="id-number{{ $i }}" value="{{ old('identify_number.' . ($i - 1)) }}"
                                    name="identify_number[]" type="text" class="form-control">
                                @if ($errors->has('identify_number.' . ($i - 1)))
                                    <span class="text-red-500 text-sm m-2 absolute top-[68px]">
                                        {{ str_replace(':crew', $i, $errors->first('identify_number.' . ($i - 1))) }}
                                    </span>
                                @endif
                            </div>
                            <div class="w-full relative flex flex-col">
                                <label for="email{{ $i }}" class="form-label p-1 font-semibold">Email: <i
                                        class="text-red-500 text-xs">*</i></label>
                                <input id="email{{ $i }}" value="{{ old('email.' . ($i - 1)) }}" name="email[]"
                                    type="text" class="form-control">
                                @if ($errors->has('email.' . ($i - 1)))
                                    <span class="text-red-500 text-sm m-2 absolute top-[68px]">
                                        {{ str_replace(':crew', $i, $errors->first('email.' . ($i - 1))) }}
                                    </span>
                                @endif
                            </div>
                            <div class="w-full relative flex flex-col">
                                <label for="phone{{ $i }}" class="form-label p-1 font-semibold">Phone: <i
                                        class="text-red-500 text-xs">*</i></label>
                                <input id="phone{{ $i }}" value="{{ old('phone.' . ($i - 1)) }}" name="phone[]"
                                    type="text" class="form-control">
                                @if ($errors->has('phone.' . ($i - 1)))
                                    <span class="text-red-500 text-sm m-2 absolute top-[68px]">
                                        {{ str_replace(':crew', $i, $errors->first('phone.' . ($i - 1))) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endfor
                <div class="intro-x w-full flex items-center mt-3">
                    <div class="w-full">
                        <button type="submit" class="block w-full btn btn-primary shadow-md mr-2 mt-5">
                            Add Crew
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
