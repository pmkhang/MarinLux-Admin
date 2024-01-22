<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingFee;
use App\Models\User;
use App\Models\Yacht;
use App\Models\YachtSpecifications;
use DateTime;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        $yachts = Yacht::select('id', 'location_id', 'name')->orderBy('name', 'ASC')->get();


        return view('admin.modules.booking.index', [
            'user' => $user,
            'yachts' => $yachts,
        ]);
    }
    public function createBooking(Request $request)
    {
        require_once app_path('Lib/generateId.php');
        $id = generateId();
        $request->validate([
            'user_id' => 'required',
            'yacht_id' => 'required',
            'dates' => 'required',
            'guests' => 'required',
            'charter' => 'required|numeric|min:1',
            'service' => 'required|numeric|min:1',
            'tax' => 'required|numeric|min:1',
            'insurance' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:1',
            'deposit' => 'required|numeric|min:1',
            'refund_amount' => 'required|numeric|min:1',
        ]);
        $yacht = Yacht::select('location_id')->where('id', $request->yacht_id)->first();
        $dateArray = explode(' - ', $request->dates);
        $startDate = $dateArray[0];
        $endDate = $dateArray[1];
        $bookingDate = Booking::select('startDate', 'endDate')
            ->where('yacht_id', $request->yacht_id)
            ->where('admin_approval_status', '!=', 3)
            ->get();

        $startDateToCheckTimestamp = strtotime($startDate);
        $endDateToCheckTimestamp = strtotime($endDate);
        $found = false;
        foreach ($bookingDate as $range) {
            $start = strtotime($range['startDate']);
            $end = strtotime($range['endDate']);
            if ($startDateToCheckTimestamp >= $start && $endDateToCheckTimestamp <= $end) {
                $found = true;
                break;
            }
            if (($startDateToCheckTimestamp >= $start && $startDateToCheckTimestamp <= $end) ||
                ($endDateToCheckTimestamp >= $start && $endDateToCheckTimestamp <= $end)
            ) {
                $found = true;
                break;
            }
            if ($startDateToCheckTimestamp < $start && $endDateToCheckTimestamp >= $end) {
                $found = true;
                break;
            }
        }

        if ($found) {
            return redirect()
                ->route('admin.booking.index', ['id' => $request->user_id])
                ->with('error', 'The date is between at least one pair of dates.');
        } else {
            $data = [
                'id' => $id,
                'user_id' => $request->user_id,
                'yacht_id' => $request->yacht_id,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'guests' => $request->guests,
                'location' => $yacht->location_id,
            ];
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
            return redirect()->route('admin.user.show', ['id' => $request->user_id])
                ->with('success', "Create booking successfully!");
        }
    }
    public function getBookingDateByYacht(Request $request)
    {
        try {
            $yacht = Yacht::select('id', 'price_per_day')->find($request->id);
            $yacht_specs = YachtSpecifications::select('crew')->where('yacht_id', $yacht->id)->first();
            $bookingDates = Booking::select('startDate', 'endDate')
                ->where('yacht_id', $yacht->id)
                ->get();

            return response()->json([
                'status' => true,
                'price_per_day' => $yacht->price_per_day,
                'bookingDates' => $bookingDates,
                'crew' => $yacht_specs->crew
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
