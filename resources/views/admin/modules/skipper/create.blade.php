@extends('admin.master')
@section('title', 'Admin - Skippers')
@section('module', 'Skippers')

@section('content')
    <form class="w-full flex flex-col gap-8" action="{{ route('admin.skipper.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-12 gap-6 mt-6">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <a href="{{ route('admin.skipper.index') }}" class="btn btn-primary shadow-md mr-2">Back to Skippers list</a>
            </div>
            <div class="intro-x col-span-12 flex flex-col gap-6">
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full relative flex flex-col">
                        <label for="name" class="form-label font-semibold">Name<i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="name" name="name" type="text" class="form-control"
                            value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full relative flex flex-col">
                        <label for="phone" class="form-label font-semibold">Phone <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="phone" name="phone" type="text" class="form-control"
                            placeholder="Ex. 09xxxxxx99" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('phone') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full relative flex flex-col">
                        <label for="email" class="form-label font-semibold">Email<i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="email" name="email" type="text" class="form-control">
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>

                    <div class="w-full relative flex flex-col">
                        <label for="supplier" class="form-label font-semibold">Supplier<i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="supplier" name="supplier" type="text" class="form-control">
                    </div>
                </div>
                <div class="intro-x w-full flex items-center mt-3">
                    <div class="w-full">
                        <button type="submit" class="block w-full btn btn-primary shadow-md mr-2">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
    </form>
@endsection
