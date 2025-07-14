<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
 public function adminlogin(Request $request) 
 {
    $credentials = $request->validate([ //first it validates the coming input data
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first(); // check database email table with user entered email
    
    // Check if user exists and password matches
    if (!$user || !Hash::check($credentials['password'], $user->password)) { // check user entered password with database password
        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    // Set session
    session([
        'user_id' => $user->id,
        'user_name' => $user->name,
        'role' => $user->role,
    ]);

    return redirect('/dashboard');
 }

 public function register(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'email'=> 'required|email',
        'password' => 'required',
    ]);
    $user = new User();

    $user->name= $request->name;
    $user->email= $request->email;
    $user->password= Hash::make($request->password);
    $user->role = 'admin';
    $user->save();
      return redirect()->route('admin.login.form')->with('success', 'Registration successful. You can now log in.');
 }

public function changePassword(Request $request)
{
    $request->validate([
        'new_password' => 'required|min:6',
    ]);

    $userId = session('user_id');

    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Password updated successfully.']);
  }

  public function logout()
  {
    Auth::logout();
    session()->flush();
    return redirect('/');
  }
}