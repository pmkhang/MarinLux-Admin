<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Mail\MarinLuxMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        //data validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray(),
            ], 422);
        }

        //jwtAuth and attempt
        $token = JWTAuth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], [
            'ttl' => 60 // (60 minutes, token expires)
        ]);

        //response
        if (!empty($token)) {
            $user = User::where('email', $request->email)->first();
            $mailData = [
                'subject' => 'Login successfully',
                'view' => 'admin.modules.email.login',
                'name' => $user->name,
                'email' => $user->email
            ];

            Mail::to($user->email)->send(new MarinLuxMail($mailData));
            return response()
                ->json([
                    'status' => true,
                    'message' => "User logged in successfully!",
                    'token' => $token,
                ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Email does not exist or password is incorrect"
            ], 401);
        }
    }

    public function register(Request $request)
    {
        try {
            require_once app_path('Lib/generateId.php');
            $id = generateId();

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|unique:users,phone',
                'password' => 'required|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->toArray(),
                ], 422);
            }

            $user = new User();
            $user->id = $id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = 1;
            $user->level = 3;
            $user->password = bcrypt($request->password);
            $user->save();

            $user = User::where('email', $request->email)->first();

            $mailData = [
                'subject' => 'Register successfully',
                'view' => 'admin.modules.email.register',
                'email' => $user->email,
                'name' => $user->name
            ];
            
            Mail::to($user->email)->send(new MarinLuxMail($mailData));

            return response()->json([
                'status' => true,
                'message' => 'Register successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => [$e->getMessage()],
            ], 422);
        }
    }
    public function profile()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                return response()->json([
                    'status' => true,
                    'message' => "Profile data",
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Unauthorized",
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|numeric|unique:users,phone,' . $user->id,
                'password' => 'required',
            ]);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found.'
                ], 404);
            }

            // Kiểm tra mật khẩu hiện tại
            if (Hash::check($request->password, $user->password)) {
                $user->name = $request->name;
                $user->email = $request->email;
                // Chỉ cập nhật mật khẩu nếu người dùng đã nhập mật khẩu mới
                if (!empty($request->new_password)) {
                    $user->password = bcrypt($request->new_password);
                }
                // Cập nhật thông tin người dùng
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => "User successfully updated."
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Current password does not match.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|different:current_password',
                'new_password_confirm' => 'required|same:new_password',
            ]);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found.'
                ], 404);
            }
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->new_password);
                $user->save();
                return response()->json([
                    'status' => true,
                    'message' => "Password successfully changed."
                ], 200);
            } else {
                // Mật khẩu hiện tại không trùng khớp
                return response()->json([
                    'status' => false,
                    'message' => 'Current password is incorrect.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
                'message' => "Something went really wrong!"
            ], 500);
        }
    }

    public function refreshToken()
    {
        $newToken = Auth::refresh();
        return response()->json([
            'status' => true,
            'message' => "New access token generated",
            'token' => $newToken
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()
            ->json([
                'status' => true,
                'message' => "User logged out successfully",
            ]);
    }
}
