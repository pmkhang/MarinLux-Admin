<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingFee;
use App\Models\Location;
use App\Models\User;
use App\Models\Yacht;
use App\Models\YachtFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Mail\MarinLuxMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;



class BookingController extends Controller
{
    public function booking(Request $request)
    {
        try {
            require_once app_path('Lib/generateId.php');
            $id = generateId();
            $request->validate([
                'userId' => 'required',
                'yachtId' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'guests' => 'required',
            ]);

            $data = [
                'id' => $id,
                'user_id' => $request->userId,
                'yacht_id' => $request->yachtId,
                'startDate' => $request->startDate,
                'endDate' => $request->endDate,
                'guests' => $request->guests,
                'location' => $request->location,
            ];

            $bookingDate = Booking::select('startDate', 'endDate')
                ->where('yacht_id', $request->yachtId)
                ->where('admin_approval_status', '!=', 3)
                ->get();

            $found = false;

            foreach ($bookingDate as $range) {
                $startDate = strtotime($range['startDate']);
                $endDate = strtotime($range['endDate']);
                $dateToCheckTimestamp = strtotime($request->startDate);
                if ($dateToCheckTimestamp >= $startDate && $dateToCheckTimestamp <= $endDate) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The date is between at least one pair of dates.',
                ]);
            } else {
                $booking = Booking::create($data);
                $fee = [
                    'booking_id' => $booking->id,
                    'charter' => $request->charter,
                    'service' => $request->service,
                    'tax' => $request->tax,
                    'insurance' => $request->insurance,
                    'deposit' => $request->deposit,
                    'refund_amount' => $request->refund_amount,
                    'total' => $request->total
                ];

                BookingFee::create($fee);

                $location = Location::find($booking->location);
                $text = "<b>A new booking has been created</b>\n\n"
                    . "<b>Booking code: </b> "
                    . "$booking->id\n\n"
                    . "<b>Start Date: </b> "
                    . "<i>$booking->startDate</i>\n\n"
                    . "<b>End Date: </b> "
                    . "<i>$booking->endDate</i>\n\n"
                    . "<b>Location: </b> "
                    . "<i>$location->name</i>\n\n"
                    . "<b>Guests: </b> "
                    . "<i>$booking->guests</i>\n\n";
                $inlineKeyboard = [
                    [
                        ['text' => 'View detail booking', 'url' => route('admin.dashboard.booking-detail', ['id' => $booking->id])]
                    ]
                ];

                try {
                    Telegram::sendMessage([
                        'chat_id' => env('TELEGRAM_CHANNEL_ID', '-1002121883961'),
                        'parse_mode' => 'HTML',
                        'text' => $text,
                        'reply_markup' => json_encode([
                            'inline_keyboard' => $inlineKeyboard
                        ]),
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => false,
                        'errors' => $e->getMessage(),
                    ]);
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Booking created successfully',
                    'bookingId' => $booking->id,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
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

    public function paymentStatus($id)
    {
        try {
            $booking = Booking::select('payment_status')->find($id);
            return response()->json([
                'status' => true,
                'paymentStatus' => $booking->payment_status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getBookingDateYacht($id)
    {
        try {
            $bookingDate = Booking::select('startDate', 'endDate')
                ->where('yacht_id', $id)
                ->where('admin_approval_status', '!=', 3)
                ->get();
            return response()->json([
                'status' => true,
                'bookingDate' => $bookingDate,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getBookingsByUser()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $bookings = Booking::where('user_id', $user->id)
                    ->with('booking_fee')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                return response()->json([
                    'status' => true,
                    'bookings' => $bookings,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getBookingById($id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::with('booking_fee')->where('user_id', $user->id)->find($id);
            if (!empty($booking)) {
                return response()->json([
                    'status' => true,
                    'booking' => $booking
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getFeedBack($id)
    {
        try {
            $booking = Booking::find($id);
            $feedbacks = YachtFeedback::where('yacht_id', $booking->yacht_id)->get();
            return response()->json([
                'status' => true,
                'feedbacks' => $feedbacks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }



    public function feedBack(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $booking = Booking::find($id);
            $yacht = Yacht::find($booking->yacht_id);
            $feedback = new YachtFeedback();
            $data = [
                'user_id' => $user->id,
                'yacht_id' => $yacht->id,
                'title' => $request->title,
                'feedback' => $request->feedback
            ];
            $feedback->create($data);
            return response()->json([
                'status' => true,
                'message' => 'feedback created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
