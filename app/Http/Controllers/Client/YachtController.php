<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Yacht;
use App\Models\YachtFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YachtController extends Controller
{
    public function getAllYachts()
    {
        try {
            $yachts = Yacht::where('status', 1)->get();

            return response()->json([
                'status' => true,
                'yachts' => $yachts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error fetching yachts: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getYachtsByFilter(Request $request)
    {
        try {
            $searchName = $request->name;
            $location = $request->location;
            $category_id = $request->category;
            $priceOrder = $request->priceOrder;

            $query = Yacht::select('id', 'name', 'description', 'category_id', 'price_per_day')
                ->with('yacht_images', 'yacht_feedbacks')
                ->where('status', 1);

            if (!empty($searchName)) {
                $query->where('name', 'LIKE', "%$searchName%");
            }
            if (!empty($location)) {
                $query->where('location_id', $location);
            }
            if (!empty($category_id)) {
                $query->where('category_id', $category_id);
            }
            if (!empty($priceOrder)) {
                $query->orderBy('price_per_day', $priceOrder);
            }

            $yachts = $query->paginate(24);

            return response()->json([
                'status' => true,
                'yachts' => $yachts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getYacht($id)
    {
        try {
            $yacht = Yacht::with('yacht_images', 'yacht_specifications')->find($id);
            if ($yacht) {
                return response()->json([
                    'status' => true,
                    'yacht' => $yacht
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Not found this yacht"
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
            $feedbacks = YachtFeedback::where('yacht_id', $id)
                ->with(['user' => function ($query) {
                    $query->select('id', 'name', 'avatar');
                }])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

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
}
