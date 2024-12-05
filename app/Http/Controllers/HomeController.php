<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered; // Mail class for sending emails


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('mobile-users.edit', compact('user'));
    }

    // Update the specified user in the database
    public function update(Request $request, User $user)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', // No unique check
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:web,mobile',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the user's details
        $user->name = $request->name;
        $user->email = $request->email;

        // Only update the password if it is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('mobile-users.index')->with('status', 'User updated successfully!');
    }


    public function destroyy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('mobile-users.index')->with('status', 'User deleted successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('mobile-users.index')->with('status', 'User deleted successfully.');
    }

    public function uploadImage(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the uploaded file
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Save the image path to the user's profile or wherever you need it
        if (Auth::check()) {
            Auth::user()->profile_image_url = '/images/' . $imageName;
            Auth::user()->save();

            return redirect()->back()->with('success', 'Image uploaded successfully');
        } else {
            return redirect()->back()->with('error', 'User not authenticated');
        }
    }

    public function updateImage(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the uploaded file
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Save the image path to the user's profile
        if (Auth::check()) {
            Auth::user()->profile_image_url = '/images/' . $imageName;
            Auth::user()->save();

            return redirect()->back()->with('success', 'Profile image updated successfully');
        } else {
            return redirect()->back()->with('error', 'User not authenticated');
        }
    }

    public function showUploadForm()
    {
        return view('users.image');
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:web,mobile',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate a plain-text password
        $plainPassword = $request->password;

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => $request->role,
        ]);

        // Send an email with the password to the user
        Mail::to($user->email)->send(new UserRegistered($user, $plainPassword));

        return redirect()->route('mobile-users.index')->with('status', 'User registered successfully, and email sent.');
    }
}
