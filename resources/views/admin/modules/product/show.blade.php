@extends('admin.master')
@section('title', 'Admin - Product')

@section('module', 'Product')

@section('content')
    <div class="intro-y p-5 box mt-6">
        <!-- BEGIN: Blog Layout -->
        <div class="flex">
            <div class="flex-1">
                <h2 class="intro-y font-medium text-xl sm:text-2xl">
                    {{ $yacht->name }}
                </h2>
            </div>
            <div class="flex-3 justify-end">
                <a class="btn btn-primary shadow-md mr-2" href="{{ route('admin.product.edit', ['id' => $yacht->id]) }}"> <i
                        data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
            </div>
        </div>
        <div class="intro-y text-slate-600 dark:text-slate-500 mt-3 text-xs sm:text-sm">
            {{ $yacht->created_at->format('d-m-Y h:i:s a') }} <span class="mx-1">•</span> <a class="text-primary"
                href="#"> {{ $yacht->category->name }} </a></div>
        <div class="intro-y mt-6 flex items-center flex-wrap gap-3">
            @foreach ($yacht->yacht_images as $image)
                <div class="">
                    <img alt="" class="rounded-md w-[200px] h-[200px] object-cover" src="{{ $image->image }}">
                </div>
            @endforeach
        </div>
        <div class="intro-y flex relative pt-16 sm:pt-6 items-center pb-6">
            @foreach ($yacht->yacht_feedbacks as $feedback)
                <div class="intro-x flex mr-3">
                    @php
                        $user_id = DB::table('users')
                            ->where('id', $feedback->user_id)
                            ->first();
                        for ($i = 0; $i < 3; $i++) {
                            if ($user_id && $feedback->orderBy('created_at')) {
                                echo "<div class='intro-x w-8 h-8 sm:w-10 sm:h-10 image-fit'>
                                            <img alt='{{ $user_id->name }}' class='rounded-full border border-white zoom-in tooltip'
                                            src='{{ $user_id->avatar }}' title='$user_id->name'>
                                            </div>";
                            }
                        }
                    @endphp
                </div>
                <div
                    class="absolute sm:relative -mt-12 sm:mt-0 w-full flex text-slate-600 dark:text-slate-500 text-xs sm:text-sm">
                    <div class="intro-x mr-1 sm:mr-3"> Comments: <span class="font-medium">{{ $feedback->count() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="intro-y ">
            <p>{{ $yacht->description }}</p>
        </div>
        <div class="intro-y box flex flex-col lg:flex-row mt-5">
            <div class="intro-y flex-1 px-5 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-gear-wide block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Builded by</div>
                <div class="text-xl font-medium text-center mt-5">{{ $yacht->yacht_specifications->builder }}</div>
            </div>
            <div
                class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-slate-200/60 dark:border-darkmode-400 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-wrench block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019.528.026.287.445.445.287.026.529L15 13l-.242.471-.026.529-.445.287-.287.445-.529.026L13 15l-.471-.242-.529-.026-.287-.445-.445-.287-.026-.529L11 13l.242-.471.026-.529.445-.287.287-.445.529-.026L13 11l.471.242z" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Year builded</div>
                <div class="text-xl font-medium text-center mt-5">{{ $yacht->yacht_specifications->year }}</div>
            </div>
            <div class="intro-y flex-1 px-5 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-grid-fill block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Cabin</div>
                <div class="text-xl font-medium text-center mt-5"> {{ $yacht->yacht_specifications->cabin }} cabins</div>
            </div>
        </div>
        <div class="intro-y box flex flex-col lg:flex-row mt-5">
            <div class="intro-y flex-1 px-5 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-people-fill block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Guests</div>
                <div class="text-xl font-medium text-center mt-5">{{ $yacht->yacht_specifications->crew }} slots</div>
            </div>
            <div
                class="intro-y border-b border-t lg:border-b-0 lg:border-t-0 flex-1 p-5 lg:border-l lg:border-r border-slate-200/60 dark:border-darkmode-400 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-rulers block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1z" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Length</div>
                <div class="text-xl font-medium text-center mt-5">{{ $yacht->yacht_specifications->length }} meters</div>
            </div>
            <div class="intro-y flex-1 px-5 py-16">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-speedometer block w-8 h-8 text-primary mx-auto" viewBox="0 0 16 16">
                    <path
                        d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z" />
                    <path fill-rule="evenodd"
                        d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z" />
                </svg>
                <div class="text-xl font-medium text-center mt-2">Speed</div>
                <div class="text-xl font-medium text-center mt-5">{{ $yacht->yacht_specifications->speed }} mph/h</div>
            </div>
        </div>
        <!-- END: Pricing Layout -->

        <!-- END: Blog Layout -->
        <!-- BEGIN: Comments -->
        <div class="intro-y mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
            <div class="text-base sm:text-lg font-medium">{{ $count_response }} Responsed </div>
        </div>
        <div class="intro-y mt-5 pb-10">
            @foreach ($yacht->yacht_feedbacks as $feedback)
                <div class="pt-5">
                    <div class="flex">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit">
                            @php
                                $user_id = DB::table('users')
                                    ->where('id', $feedback->user_id)
                                    ->first();
                                if ($user_id) {
                                    echo "<img alt='{{ $user_id->name }}' class='rounded-full'
                                                    src='{{ $user_id->avatar }}'>";
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
