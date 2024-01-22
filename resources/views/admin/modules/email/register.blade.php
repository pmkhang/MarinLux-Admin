@extends('admin.modules.email.master')

@section('content')
    <div>
        <h1>Welcome to MarinLux</h1>
        <br>
        <hr>
        <br>
        <h2>Register successfully</h2>
        <p><b>{{ $mailData['email'] }}</b></p>
        <p><b>{{ $mailData['name'] }}</b></p>
    </div>
@endsection
