@extends('admin.master')
@section('title', 'Admin - Users')
@section('module', 'Users')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.user.index') }}" class="btn btn-primary shadow-md mr-2">Back to Users list</a>
        </div>

        <div class="intro-x col-span-12">
            <form class="w-full flex flex-col gap-8" action="{{ route('admin.user.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full relative flex flex-col">
                        <label for="name" class="form-label font-semibold">
                            Fullname
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Ex. Join Cena"
                            value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="w-full relative flex flex-col">
                        <label for="email" class="form-label font-semibold">Email <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="email" name="email" type="text" class="form-control"
                            placeholder="Ex. example@gmail.com" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('email') }}
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
                        <label for="password" class="form-label font-semibold">Password <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="password" name="password" type="password" class="form-control">
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                    <div class="w-full relative flex flex-col">
                        <label for="passwordConfirm" class="form-label font-semibold">Password confirm <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="passwordConfirm" name="password_confirmation" type="password" class="form-control">
                        @if ($errors->has('password_confirmation'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full">
                        <label class="form-label font-semibold">Status</label>
                        <select name="status" class="tom-select w-full">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="form-label font-semibold">Level</label>
                        <select name="level" class="tom-select w-full">
                            <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Super Admin</option>
                            <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Admin</option>
                            <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>
                </div>
                <label for="avatar" data-single="true"
                    class="intro-x dropzone text-xl flex items-center justify-center cursor-pointer">
                    Click to upload Avatar.

                </label>

                @if ($errors->has('avatar'))
                    <span class="text-red-500 text-sm">
                        {{ $errors->first('avatar') }}
                    </span>
                @endif
                <input id="avatar" name="avatar" type="file" hidden />
                <div class="w-full flex items-center justify-center">
                    <img id="preview-image" src=""
                        class="w-[250px] h-[250px] mt-3 p-2 bg-white rounded-full object-contain border border-gray-400">
                </div>
                <div class="intro-x w-full flex items-center mt-3">
                    <div class="w-full">
                        <button type="submit" class="block w-full btn btn-primary shadow-md mr-2">
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script>
        $(document).ready(function() {
            $('#avatar').on('change', function(event) {
                const selectedFile = event.target.files[0];
                const previewImage = $('#preview-image')[0];
                if (selectedFile) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                    };
                    reader.readAsDataURL(selectedFile);
                } else {
                    previewImage.src = '';
                }
            });
        });
    </script>
@endsection
