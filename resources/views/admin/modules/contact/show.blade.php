@extends('admin.master')
@section('title', 'Admin - Contact')
@section('module', 'Contact')
@section('content')
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="bg-white p-5 col-span-12 rounded-lg shadow-md">
            <h3 class="text-center text-xl font-bold">Contact detail</h3>
            <div class="flex flex-col gap-3">
                <p class="font-bold">Name: {{ $contact->name }}</p>
                <p class="font-bold">Email: {{ $contact->email }}</p>
                <p class="font-bold">Phone: {{ $contact->phone }}</p>
                <div>
                    <p class="font-bold">Messsager:</p>
                    <p class="mt-2">
                        {{ $contact->messager }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
