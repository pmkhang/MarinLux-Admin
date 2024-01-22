@extends('admin.modules.email.master')

@section('content')
    <div>
        <h1>Welcome to MarinLux</h1>
        <p><b>{{ $mailData['name'] }}</b></p>
        <br>
        <hr>
        <br>
    </div>
@endsection
