<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getLocations()
    {
        $locations = Location::all();
        return response()->json([
            'status' => true,
            'locations' => $locations
        ]);
    }
}
