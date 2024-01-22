@extends('admin.master')
@section('title', 'Admin - Category')
@section('module', 'Category')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.category.index') }}" class="btn btn-primary shadow-md mr-2">Back to Category list</a>
        </div>

        <div class="intro-x col-span-12">
            <form class="w-full flex flex-col gap-8" action="{{ route('admin.category.update', ['id' => $category->id]) }}"
                method="POST">
                @csrf

                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full relative flex flex-col">
                        <label for="name" class="form-label p-1 font-semibold">Category name: <i
                                class="text-red-500 text-xs">*</i></label>
                        <input value="{{ old('name', $category->name) }}" name="name" type="text"
                            class="form-control">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm m-2 absolute top-[68px] ">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="w-full">
                    <label class="form-label font-semibold">Status</label>
                    <select name="status" class="tom-select w-full">
                        <option value="1" {{ old('status', $category->status) === 1 ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ old('status', $category->status) === 2 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="intro-x w-full flex items-center mt-3">
                    <div class="w-full">
                        <button type="submit" class="block w-full btn btn-primary shadow-md mr-2 mt-5">
                            Update now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
