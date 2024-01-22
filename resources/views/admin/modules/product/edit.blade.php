@extends('admin.master')
@section('title', 'Admin - Products')
@section('module', 'Product')

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('admin.product.index') }}" class="btn btn-primary shadow-md mr-2">Back to Product list</a>
        </div>
        <div class="intro-x col-span-12">
            <form class="w-full flex flex-col gap-8" action="{{ route('admin.product.update', ['id' => $yacht->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="w-full">
                        <label class="form-label font-semibold">Categories</label>
                        <select name="category" class="tom-select w-full">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category', $yacht->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="form-label font-semibold">Locations</label>
                        <select name="location" class="tom-select w-full">
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location', $yacht->location_id) == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="name" class="form-label font-semibold">
                            Yacht name
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="name" name="name" type="text" class="form-control"
                            value="{{ old('name', $yacht->name) }}">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="price" class="form-label font-semibold">Price per day <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="price" name="price" type="text" class="form-control"
                            value="{{ old('price', $yacht->price_per_day) }}">
                        @if ($errors->has('price'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('price') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="description" class="form-label font-semibold">Description <i
                                class="text-red-500 text-xs">*</i>
                        </label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="10">{{ old('description', $yacht->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-red-500 text-sm font-normal mt-2">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex flex-col">
                    <label class="form-label font-semibold">Status</label>
                    <select name="status" class="tom-select w-full">
                        <option value="1" {{ old('status', $yacht->status) == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="2" {{ old('status', $yacht->status) == 2 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
                <h3 class="form-label font-semibold text-lg">Specifications</h3>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="cabin" class="form-label font-semibold">
                            Cabin
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="cabin" name="cabin" type="text" class="form-control"
                            value="{{ old('cabin', $yacht->yacht_specifications->cabin) }}">
                        @if ($errors->has('cabin'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('cabin') }}
                            </span>
                        @endif
                    </div>
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="length" class="form-label font-semibold">Length <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="length" name="length" type="text" class="form-control"
                            value="{{ old('length', $yacht->yacht_specifications->length) }}">
                        @if ($errors->has('length'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('length') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="beam" class="form-label font-semibold">
                            Beam
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="beam" name="beam" type="text" class="form-control"
                            value="{{ old('beam', $yacht->yacht_specifications->beam) }}">
                        @if ($errors->has('beam'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('beam') }}
                            </span>
                        @endif
                    </div>
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="speed" class="form-label font-semibold">Speed <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="speed" name="speed" type="text" class="form-control"
                            value="{{ old('speed', $yacht->yacht_specifications->speed) }}">
                        @if ($errors->has('speed'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('speed') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="crew" class="form-label font-semibold">
                            Crew
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="crew" name="crew" type="text" class="form-control"
                            value="{{ old('crew', $yacht->yacht_specifications->crew) }}">
                        @if ($errors->has('crew'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('crew') }}
                            </span>
                        @endif
                    </div>
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="year" class="form-label font-semibold">Year build <i
                                class="text-red-500 text-xs">*</i></label>
                        <input id="year" name="year" type="text" class="form-control"
                            value="{{ old('year', $yacht->yacht_specifications->year) }}">
                        @if ($errors->has('year'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('year') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="intro-x w-full flex items-center gap-4">
                    <div class="intro-x w-full relative flex flex-col">
                        <label for="builder" class="form-label font-semibold">
                            Builder
                            <i class="text-red-500 text-xs">*</i>
                        </label>
                        <input id="builder" name="builder" type="text" class="form-control"
                            value="{{ old('builder', $yacht->yacht_specifications->builder) }}">
                        @if ($errors->has('builder'))
                            <span class="text-red-500 text-sm absolute top-[68px] ">
                                {{ $errors->first('builder') }}
                            </span>
                        @endif
                    </div>
                </div>
                <h3 class="form-label font-semibold text-lg">Images</h3>


                @if (count($yacht->yacht_images) > 0)
                    <div id="currentImage" class="intro-x w-full flex flex-col items-center justify-center gap-4">
                        <span class="text-xl font-bold">Current images</span>
                        <div class="flex items-center justify-center gap-4">
                            @foreach ($yacht->yacht_images as $image)
                                <div class="relative img-{{ $image->id }}">
                                    <span data-id="{{ $image->id }}"
                                        data-urlDelImg="{{ route('delete-image', ['id' => $image->id]) }}"
                                        class="del-img absolute top-[-10px] right-[-10px] border border-slate-300 rounded-full cursor-pointer flex items-center justify-center w-10 h-10 bg-white"><i
                                            class="fa-solid fa-x"></i></span>
                                    <img src="{{ $image->image }}" alt="{{ $image->id }}"
                                        class="img-{{ $image->id }} w-[200px] h-[200px] object-cover border border-slate-300 p-2">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div id="uploadImage" class="intro-x w-full flex items-center gap-4">
                    <label for="image" style="min-height: 60px"
                        class="intro-x w-full text-xl flex flex-col items-center justify-center cursor-pointer">
                        <p class="text-2xl mt-2">Click to upload Yacht Images.</p>
                        <p class="text-sm mt-2">You can choose multiple images</p>
                        @if ($errors->has('images'))
                            <span class="text-red-500 text-sm font-normal">
                                {{ $errors->first('images') }}
                            </span>
                        @endif
                    </label>
                    <input id="image" type="file" multiple name="images[]" hidden>
                </div>
                <div id="imagePreview" class="intro-x w-full flex items-center justify-center gap-4">
                    <!-- Hình ảnh được hiển thị sẽ được đặt ở đây -->
                </div>
                <div class="intro-x w-full flex items-center mt-3 ">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
    <script>
        const delImg = async (url, id) => {
            try {
                const response = await axios.get(url);
                $(`div.img-${id}`).remove();
            } catch (error) {
                console.error('Error deleting image:', error);
            }
        };
        $(document).ready(function() {
            $('.del-img').on('click', function() {
                const id = $(this).data('id');
                const url = $(this).data('urlDelImg');
                delImg(url, id);
            });
            $('#image').on('change', function(e) {
                const files = e.target.files;
                const value = $(this).val();
                for (var i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        console.log(value)
                        let img = $('<img src="' + e.target.result +
                            '" class="preview-image w-[200px] h-[200px] object-cover" />');
                        $('#imagePreview').append(img);
                    };
                    reader.readAsDataURL(files[i]);
                }
            });
        });
    </script>

@endsection
