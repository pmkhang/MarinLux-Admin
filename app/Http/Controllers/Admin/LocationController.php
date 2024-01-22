<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Location\StoreRequest;
use App\Http\Requests\Location\UpdateRequest;
use App\Models\Yacht;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('created_at', 'DESC')->get();
        return view('admin.modules.location.index', [
            'locations' => $locations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        return view('admin.modules.location.create', [
            'locations' => $locations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = [
            'name' => $request->name,
        ];
        $location = Location::create($data);
        $location->save();
        return redirect()->route('admin.location.index')->with('success', "Create Location $location->name success!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('admin.modules.location.edit', [
            'location' => $location,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $location = Location::findOrFail($id);
        $update_location = [
            'name' => $request->name,
        ];
        $location->update($update_location);
        return redirect()->route('admin.location.index')->with('success', "Update Location $location->name successfully!");
    }

}
