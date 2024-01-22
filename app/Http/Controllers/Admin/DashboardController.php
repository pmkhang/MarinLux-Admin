<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Contact;
use App\Models\CrewMember;
use App\Models\Location;
use App\Models\Skipper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $pending = Booking::select('admin_approval_status')
            ->where('admin_approval_status', 1)
            ->count();

        $booking = Booking::all();
        $total_booking = $booking->count();
        $notSeenContactCount = Contact::where('status', 1)->count();
        $totalContactCount = Contact::count();

        if (!empty($booking) && $total_booking > 0) {
            $approved =  $total_booking - $pending;
            $percent_pending =  ($pending /  $total_booking) * 100;
            $percent_approved =  ($approved /  $total_booking) * 100;

            return view('admin.modules.dashboard.index', [
                'pending' => $pending,
                'percent_approved' => $percent_approved,
                'percent_pending' => $percent_pending,
                'total' => $total_booking,
                'notSeenContactCount' => $notSeenContactCount,
                'totalContactCount' => $totalContactCount
            ]);
        }

        return view('admin.modules.dashboard.index', [
            'pending' => $pending,
            'percent_approved' => 0,
            'percent_pending' => 0,
            'total' => $total_booking,
            'notSeenContactCount' => $notSeenContactCount,
            'totalContactCount' => $totalContactCount
        ]);
    }

    public function list_booking(Request $request)
    {
        $bookings = Booking::where('admin_approval_status', 1)->paginate(10);
        $index = ($bookings->currentPage() - 1) * $bookings->perPage() + 1;
        $select = $request->select;
        if ($select) {
            $bookings = Booking::where('admin_approval_status', 1)->paginate($select);
            $index = ($bookings->currentPage() - 1) * $bookings->perPage() + 1;
            return view('admin.modules.dashboard.booking', [
                'bookings' => $bookings,
                'index' => $index,
                'select' => $select
            ]);
        }
        return view('admin.modules.dashboard.booking', [
            'bookings' => $bookings,
            'index' => $index,
            'select' => $select
        ]);
    }

    public function bookings(Request $request)
    {
        $bookings = Booking::orderBy('created_at', 'DESC')->paginate(10);
        $index = ($bookings->currentPage() - 1) * $bookings->perPage() + 1;
        $select = $request->select;
        if ($select) {
            $bookings = Booking::where('admin_approval_status', 1)->paginate($select);
            $index = ($bookings->currentPage() - 1) * $bookings->perPage() + 1;
            return view('admin.modules.dashboard.listbooking', [
                'bookings' => $bookings,
                'index' => $index,
                'select' => $select
            ]);
        }
        return view('admin.modules.dashboard.listbooking', [
            'bookings' => $bookings,
            'index' => $index,
            'select' => $select
        ]);
    }

    public function booking_detail(string $id)
    {
        $booking = Booking::with('skipper', 'user', 'yacht', 'booking_fee', 'crew_members')->findOrFail($id);
        $crewMembers = 0;
        if (!empty($booking->crew_members->count())) {
            $crewMembers = $booking->crew_members->count();
        }
        $yacht = $booking->yacht;
        $category = Category::where('id', $yacht->category_id)->first();
        $location = Location::where('id', $booking->location)->first();
        $skippers = Skipper::all();
        $skipperName = '';

        if ($booking->skipper && $booking->skipper->name) {
            $skipperName = $booking->skipper->name;
        }

        return view('admin.modules.dashboard.bookingdetail', [
            'booking' => $booking,
            'category' => $category,
            'location' => $location,
            'skippers' => $skippers,
            'skipperName' => $skipperName,
            'crewMembers' => $crewMembers
        ]);
    }

    public function adminAction(Request $request, $id)
    {
        $booking = Booking::with('booking_fee')->findOrFail($id);
        $today = Carbon::now();
        $startDate = Carbon::parse($booking->startDate);

        $skipper_id = $request->skipper_id;
        $refund_status = $request->refund_status;
        $admin_approval_status = $request->admin_approval_status;
        $payment_status = $request->payment_status;

        if (!empty($skipper_id)) {
            $booking->update(['skipper_id' => $skipper_id]);
        }

        if (!empty($refund_status)) {
            $booking->update(['refund_status' => $refund_status]);
        }

        if (!empty($admin_approval_status)) {
            if ($admin_approval_status == 3) {
                $booking->update(['refund_status' => 2]);
                if ($startDate->gt($today->addDays(3))) {
                    $booking->booking_fee()->update([
                        'refund_amount' => $booking->booking_fee->deposit,
                    ]);
                } elseif ($startDate->lte($today) && $startDate->gt($today->subDays(3))) {
                    $booking->booking_fee()->update([
                        'refund_amount' => $booking->booking_fee->deposit - ($booking->booking_fee->total * (1 / 3)),
                    ]);
                } else {
                    $booking->booking_fee()->update([
                        'refund_amount' => $booking->booking_fee->refund_amount,
                    ]);
                }
            }
            $booking->update(['admin_approval_status' => $admin_approval_status]);
        }

        if (!empty($payment_status)) {
            if ($payment_status == 3) {
                $booking->update(['admin_approval_status' => 3]);
                $booking->update(['refund_status' => 3]);
                $booking->booking_fee()->update([
                    'deposit' => 0,
                    'refund_amount' => 0,
                ]);
            }
            $booking->update(['payment_status' => $payment_status]);
        }

        return redirect()->route('admin.dashboard.booking-detail', ['id' => $id]);
    }

    public function addCrewMember($id)
    {
        $booking = Booking::select('guests')->findOrFail($id);
        $guests = $booking->guests;

        return view('admin.modules.dashboard.addcrew', [
            'guests' => $guests,
            'id' => $id,
        ]);
    }
    public function createCrewMember(Request $request, $id)
    {
        $request->validate([
            'name.*' => 'required',
            'identify_number.*' => 'required',
            'email.*' => 'required',
            'phone.*' => 'required',
        ], [
            'name.*.required' => 'The name field for Crew :crew is required.',
            'identify_number.*.required' => 'The ID number field for Crew :crew is required.',
            'email.*.required' => 'The email field for Crew :crew is required.',
            'phone.*.required' => 'The phone field for Crew :crew is required.',
        ]);

        $datas = [];

        foreach ($request->name as $key => $val) {
            $datas[$key] = [
                'name' => $val,
                'booking_id' => $id,
                'identify_number' => $request->identify_number[$key],
                'email' => $request->email[$key],
                'phone' => $request->phone[$key],
            ];
        }

        foreach ($datas as $data) {
            CrewMember::create($data);
        }
        return redirect()->route('admin.dashboard.booking-detail', ['id' => $id])->with('success', 'Add Crew Members Successfully');
    }
    public function search(Request $request)
    {
        $search = $request->search;
        $search = preg_replace('/[^a-zA-Z0-9@.\-]/', '', $search);
        $search = strtoUpper($search);
        $users = DB::table('users')
            ->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%");
            })
            ->take(5)
            ->get();

        $yachts = DB::table('yachts')
            ->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('name', 'like', "%$search%");
            })
            ->take(5)
            ->get();

        $bookings = DB::table('bookings')
            ->where('id', "LIKE", "%$search%")
            ->orWhere('admin_approval_status', 'like', "%$search%")
            ->take(5)
            ->get();

        if (!empty($search)) {
            if ($users->isNotEmpty()) {
                $html = "";
                foreach ($users as $user) {
                    $html .= '<a href="' . route('admin.user.show', ['id' => $user->id]) . '" class="p-2 flex hover:font-bold items-center mt-3">
                                <div class="w-8 h-8 image-fit">
                                    <img class="rounded-full" src="' . $user->avatar . '">
                                </div>
                                <div class="ml-3">' . $user->name . '</div>
                                <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">' . $user->email . '</div>
                            </a>';
                }
                return response($html);
            } elseif ($yachts->isNotEmpty()) {
                $html = "";
                foreach ($yachts as $yacht) {
                    $yachtImage = DB::table('yacht_images')->where('yacht_id', $yacht->id)->first();
                    $category = DB::table('categories')->where('id', $yacht->category_id)->first();

                    $html .= '<a href="' . route('admin.product.show', ['id' => $yacht->id]) . '" class="p-2 flex items-center hover:font-bold mt-2">
                                    <div class="w-8 h-8 image-fit">
                                        <img class="rounded-full" src="' . ($yachtImage ? $yachtImage->image : 'path_to_default_image_if_not_found') . '">
                                    </div>
                                    <div class="ml-3">' . $yacht->name . '</div>
                                    <div class="ml-auto w-48 truncate text-slate-500 text-xs text-right">' . ($category ? $category->name : 'Uncategorized') . '</div>
                                </a>';
                }
                return response($html);
            } elseif ($bookings->isNotEmpty()) {
                $html = "";
                foreach ($bookings as $booking) {
                    $status = '';
                    if ($booking->admin_approval_status == 1) {
                        $status = 'Pending';
                    } elseif ($booking->admin_approval_status == 2) {
                        $status = 'Approved';
                    } else {
                        $status = 'Cancelled';
                    }
                    $html .= '<a href="' . route('admin.dashboard.booking-detail', ['id' => $booking->id]) . '" class="p-2 flex items-center hover:font-medium mt-3">
                                <div class="ml-3">' . $booking->id . '</div>
                                <div class="ml-6">' . $status . '</div>
                                </a>';
                }
                return response($html);
            } else {
                $html = '<p." class="flex items-center font-bold">
                            Data not found
                        </p>';
                return response($html);
            }
        }
    }
}
