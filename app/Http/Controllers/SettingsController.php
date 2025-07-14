<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class SettingsController extends Controller
{
public function settings()
{
    $categories = Product::select('category')
        ->whereNotNull('category')
        ->distinct()
        ->pluck('category');

    $medications = Product::where('category', 'medication')->pluck('name');

    $user = User::find(session('user_id'));

    return view('settings', compact('categories', 'medications', 'user'));
}

public function insertContact(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'address' => 'required|string|max:255',
        'phone_no' => 'required|string|max:20',
    ]);

    $user = User::find($request->user_id);
    $user->address = $request->address;
    $user->phone_no = $request->phone_no;
    $user->save();

    return redirect()->back()->with('success', 'Contact info inserted successfully.');
}
}
