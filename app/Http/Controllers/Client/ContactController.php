<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'messager' => 'required|string',
            ]);
            
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'messager' => $request->messager
            ];

            Contact::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Successfully created',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
