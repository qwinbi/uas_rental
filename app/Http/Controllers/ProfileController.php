<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully! 🎉');
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('car')
            ->latest()
            ->paginate(10);
            
        return view('profile.history', compact('transactions'));
    }

    public function favorites()
    {
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('car')
            ->latest()
            ->paginate(12);
            
        return view('profile.favorites', compact('favorites'));
    }

    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id'
        ]);

        $userId = Auth::id();
        $carId = $request->car_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('car_id', $carId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Removed from favorites! 💔';
            $isFavorite = false;
        } else {
            Favorite::create([
                'user_id' => $userId,
                'car_id' => $carId
            ]);
            $message = 'Added to favorites! 💖';
            $isFavorite = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_favorite' => $isFavorite
        ]);
    }
}