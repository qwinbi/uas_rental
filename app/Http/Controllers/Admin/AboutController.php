<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'class' => 'required|string|max:50',
            'major' => 'required|string|max:100',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $about = About::first();

        if ($request->hasFile('avatar')) {
            if ($about && $about->avatar) {
                Storage::disk('public')->delete($about->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('about', 'public');
        }

        if ($about) {
            $about->update($validated);
        } else {
            About::create($validated);
        }

        return redirect()->route('admin.about.edit')
            ->with('success', 'About page updated successfully! 📝');
    }
}