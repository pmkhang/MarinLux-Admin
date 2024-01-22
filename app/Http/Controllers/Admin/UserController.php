<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('status', '!=', 3)->orderBy('created_at', 'DESC')->paginate(10);
        $index = ($users->currentPage() - 1) * $users->perPage() + 1;
        $userCount = $users->count();
        $select = $request->select;
        if ($select) {
            $users = User::where('status', '!=', 3)->orderBy('created_at', 'DESC')->paginate($select);
            $index = ($users->currentPage() - 1) * $users->perPage() + 1;
            return view('admin.modules.user.index', [
                'users' => $users,
                'index' => $index,
                'select' => $select,
                'userCount' => $userCount
            ]);
        }
        return view('admin.modules.user.index', [
            'users' => $users,
            'userCount' => $userCount,
            'index' => $index,
            'select' => $select,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $file = $request->avatar;
        if ($file) {
            $request->validate([
                'avatar' => 'required|mimes:jpg,bmp,png,jpeg,gif',
            ], [
                'avatar.required' => 'Please upload an image!',
                'avatar.mimes' => 'Image must be in one of the following formats: jpg, bmp, png, jpeg, gif!',
            ]);
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/'), $filename);
            $url_image = asset('uploads/' . $filename);
        } else {
            $url_image = null;
        }

        require_once app_path('Lib/generateId.php');
        $data = [
            'id' => generateId(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'status' => $request->status,
            'level' => $request->level,
            'avatar' => $url_image,
        ];
        User::create($data);
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Create a new user successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { {

            $user = User::findOrFail($id);
            $bookings = Booking::where('user_id', $id)->orderBy('created_at', 'DESC')->get();

            return view("admin.modules.user.show", [
                'user' => $user,
                'bookings' =>  $bookings,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = User::findOrFail($id);
        $edit_myself = null;
        if (Auth::user()->id == $id) {
            $edit_myself = true;
        } else {
            $edit_myself = false;
        }

        if (Auth::user()->level == 2 && ($user["level"] == 1 || ($user["level"] == 2 && $edit_myself == false))) {
            return redirect()
                ->route('admin.user.index')
                ->with('error', 'You do not have permission to edit this user.');
        }

        return view('admin.modules.user.edit', [
            'id' => $id,
            'user' => $user,
            'is_myself' => $edit_myself
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $url_image = '';

        $file = $request->file('avatar');
        if (!empty($file)) {
            $request->validate([
                'avatar' => 'required|mimes:jpg,bmp,png,jpeg,gif',
            ], [
                'avatar.required' => 'Please upload an image!',
                'avatar.mimes' => 'Image must be in one of the following formats: jpg, bmp, png, jpeg, gif!',
            ]);
            $old_image = public_path('uploads/' . basename($user->avatar));
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/'), $filename);
            $url_image = asset('uploads/' . $filename);
        }

        $data = [
            'id' => $user->id,
            'name' => $request->name,
            'email' => $user->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'level' => $user->level,
            'avatar' => $url_image,
        ];

        if (!empty($request->password)) {
            $request->validate(
                [
                    'password' => [
                        'required',
                        'confirmed',
                        'min:8',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                    ],
                    'password_confirmation' => 'required|same:password'
                ],
                [
                    'password.required' => 'Please enter a password !',
                    'password.confirmed' => 'Password confirmation does not match !',
                    'password_confirmation.same' => 'Password confirmation does not match !',
                    'password.min' => 'Password must be at least 8 characters long !',
                    'password.regex' => 'Password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character (a-z, A-Z, 0-9, !-*) !'
                ]
            );
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Update user successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->status = 3;
        $user->save();
        return redirect()
            ->route('admin.user.index')
            ->with('success', 'Delete user successfully');
    }

    public function createUserAdmin()
    {
        require_once app_path('Lib/generateId.php');
        $data = [
            'id' => generateId(),
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '000000000',
            'password' => bcrypt('Admin@123'),
            'status' => 1,
            'level' => 1,
            'avatar' => 'https://images2.thanhnien.vn/zoom/686_429/528068263637045248/2023/2/8/iron-167583014085865406483-0-46-542-913-crop-1675830190221882222413.jpg',
        ];

        User::create($data);

        return response()->json([
            'message' => 'Created',
            'email' => 'admin@gmail.com',
            'password' => 'Admin@123'
        ]);
    }
}
