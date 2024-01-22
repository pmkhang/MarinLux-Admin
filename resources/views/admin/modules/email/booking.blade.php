@extends('admin.modules.email.master')

@section('content')
    <div>
        <h1>Scheduled successfully</h1>
        <p>Your booking code: <b>{{ $mailData['booking_code'] }}</b></p>
        <p>Start date: <b>{{ $mailData['startDate'] }}</b></p>
        <p>End Date: <b>{{ $mailData['endDate'] }}</b></p>
        <p>
            <a href="{{ $mailData['googleCalendarLink'] }}" target="_blank">
                Add to Google Calendar
            </a>
        </p>
        <br>
        <hr>
        <br>
        <p>Total: <b>${{ $mailData['total'] }}</b></p>
        <p>Deposit: <b>${{ $mailData['deposit'] }}</b></p>
        <p>Refund amount: <b>${{ $mailData['refund_amount'] }}</b></p>
        <p>Booking detail: <b><a href="{{ $mailData['link'] }}">Click here</a></b></p>
        <br>
        <hr>
        <br>
    </div>
@endsection
