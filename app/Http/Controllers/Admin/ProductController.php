<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use App\Models\Yacht;
use App\Models\YachtFeedback;
use App\Models\YachtImages;
use App\Models\YachtSpecifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\HtmlString;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $yachts = Yacht::with('category', 'location')->where('status', '!=', 3)->paginate(10);
        $index = ($yachts->currentPage() - 1) * $yachts->perPage() + 1;
        $select = $request->select;
        if ($select) {
            $yachts = Yacht::with('category', 'location')->where('status', '!=', 3)->paginate($select);
            $index = ($yachts->currentPage() - 1) * $yachts->perPage() + 1;
            return view('admin.modules.product.index', [
                'yachts' => $yachts,
                'index' => $index,
                'select' => $select
            ]);
        }
        return view('admin.modules.product.index', [
            'yachts' => $yachts,
            'index' => $index,
            'select' => $select
        ]);
    }

    public function create()
    {
        $categories = Category::get();
        $locations = Location::get();
        return view('admin.modules.product.create', [
            'categories' => $categories,
            'locations' => $locations
        ]);
    }

    public function store(StoreRequest $request)
    {

        require_once app_path('Lib/generateId.php');
        $data = [
            'id' => generateId(),
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price,
            'status' => $request->status,
            'category_id' => $request->category,
            'location_id' => $request->location,
        ];
        $yacht = Yacht::create($data);
        $yacht_specifications = [
            'cabin' => $request->cabin,
            'length' => $request->length,
            'speed' => $request->speed,
            'crew' => $request->crew,
            'beam' => $request->beam,
            'year' => $request->year,
            'builder' => $request->builder,
            'yacht_id' => $yacht->id
        ];
        YachtSpecifications::create($yacht_specifications);

        $files = $request->images;
        if ($files) {
            foreach ($files as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads/'), $filename);
                $url_image = asset('uploads/' . $filename);
                YachtImages::create([
                    'yacht_id' => $yacht->id,
                    'image' => $url_image
                ]);
            }
        }
        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Create a new product successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        $yacht = Yacht::with('category', 'yacht_images', 'yacht_feedbacks', 'bookings', 'yacht_specifications', 'location')->findOrFail($id);
        $user_id = auth()->user()->id;
        $userFeedbacks = $yacht->yacht_feedbacks()->where('user_id', $user_id)->get();
        $response = $yacht->yacht_feedbacks->count();
        $time_feedback = Carbon::now();

        return view("admin.modules.product.show", [
            'yacht' => $yacht,
            'userFeedbacks' =>  $userFeedbacks,
            'count_response' => $response,
            'time_feedback' =>  $time_feedback,
        ]);
    }

    public function edit($id)
    {
        $categories = Category::get();
        $locations = Location::get();
        $yacht = Yacht::with('yacht_images', 'yacht_specifications')->findOrfail($id);
        // dd($yacht->toArray());
        return view('admin.modules.product.edit', [
            'categories' => $categories,
            'yacht' => $yacht,
            'locations' => $locations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $yacht = Yacht::with('yacht_images', 'yacht_specifications')->findOrFail($id);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price,
            'status' => $request->status,
            'category_id' => $request->category,
            'location_id' => $request->location,
        ];
        $yacht->update($data);
        $yacht_specifications = [
            'cabin' => $request->cabin,
            'length' => $request->length,
            'speed' => $request->speed,
            'crew' => $request->crew,
            'beam' => $request->beam,
            'year' => $request->year,
            'builder' => $request->builder,
            'yacht_id' => $yacht->id
        ];
        $yacht->yacht_specifications()->update($yacht_specifications);

        $files = $request->images;
        if ($files) {
            $request->validate([
                'images' => 'required|array',
                'images.*' => 'mimes:jpeg,png,jpg,gif'
            ]);
            foreach ($files as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads/'), $filename);
                $url_image = asset('uploads/' . $filename);
                $yacht->yacht_images()->create([
                    'image' => $url_image
                ]);
            }
        }
        return redirect()->route('admin.product.index')->with('success', 'Update yacht successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $yacht = Yacht::findOrFail($id);
        // $yacht_images = $yacht->yacht_images;
        // foreach ($yacht_images as $image) {
        //     $file_old_url = public_path('uploads/' . basename($image->image));
        //     if (file_exists($file_old_url)) {
        //         unlink($file_old_url);
        //     }
        //     $image->delete();
        // }
        $yacht->update([
            'status' => 3
        ]);
        return redirect()->route('admin.product.index')->with('success', 'Deleted yacht successfully');
    }

    public function deleteImage($id)
    {
        $image = YachtImages::findOrFail($id);
        $file_old_url = public_path('uploads/' . basename($image->image));
        if (file_exists($file_old_url)) {
            unlink($file_old_url);
        }
        $image->delete();
        return response()->json([
            'status' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $yachts = Yacht::select('name', 'id')->where('name', 'like', "%$search%")->get();
        $html = '';

        if ($yachts->isEmpty()) {
            $html .= '<p class="flex items-center p-3 text-slate-400">Data not found</p>';
        }
        foreach ($yachts as $yacht) {
            $html .= '<a href="' . route('admin.product.show', ['id' => $yacht->id]) . '" class="flex items-center p-3">
                        <p class="text-slate-400 hover:font-bold">' . $yacht->name . '</p>
                    </a>';
        }
        return response($html);
    }
}
