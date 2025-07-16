<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
 public function adminlogin(Request $request) 
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // First: Try login as USER (admin/vet/staff)
    $user = User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['password'], $user->password)) {
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'role' => $user->role,
            'is_client' => false
        ]);
        return redirect('/dashboard');
    }

    // Second: Try login as CLIENT (phone as password)
    $client = Client::where('email', $credentials['email'])->first();

    if ($client && $client->phone === $credentials['password']) {
        session([
            'user_id' => $client->id,
            'user_name' => $client->name,
            'role' => 'client',
            'is_client' => true
        ]);
        return redirect('/dashboard'); // redirect client to chat
    }

    // If neither worked
    return back()->with('error', 'Invalid credentials.');
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