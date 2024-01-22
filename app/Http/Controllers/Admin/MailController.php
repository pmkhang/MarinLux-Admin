<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MarinLuxMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function bookingSuccess(Request $request, $id)
    {
        try {
            $booking = Booking::with('booking_fee')->find($id);
            $user = User::find($booking->user_id);

            $googleCalendarLink = $this->generateGoogleCalendarLink(
                "Booking MarinLux Yacht - " . $booking->id,
                $booking->startDate,
                $booking->endDate
            );

            $mailData = [
                'subject' => 'Booking yacht',
                'view' => 'admin.modules.email.booking',
                'booking_code' => $booking->id,
                'startDate' => $booking->startDate,
                'endDate' => $booking->endDate,
                'total' => $booking->booking_fee->total,
                'deposit' => $booking->booking_fee->deposit,
                'refund_amount' => $booking->booking_fee->refund_amount,
                'link' => $request->link,
                'googleCalendarLink' => $googleCalendarLink,
            ];

            Mail::to($user->email)->send(new MarinLuxMail($mailData));

            return response()->json([
                'message' => 'Send mail successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function generateGoogleCalendarLink($title, $startDate, $endDate)
    {
        $startDate = Carbon::parse($startDate)->setTime(12, 0, 0)->utc()->format('Ymd\THis\Z');
        $endDate = Carbon::parse($endDate)->setTime(12, 0, 0)->utc()->format('Ymd\THis\Z');

        $googleCalendarLink = "https://www.google.com/calendar/render?action=TEMPLATE";
        $googleCalendarLink .= "&text=" . urlencode($title);
        $googleCalendarLink .= "&dates=" . urlencode($startDate . "/" . $endDate);

        return $googleCalendarLink;
    }
}
