<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function edit()
    {
        $logo = Logo::first();
        return view('admin.logo.edit', compact('logo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024'
        ]);

        $logo = Logo::first();

        if ($request->hasFile('logo')) {
            if ($logo && $logo->logo_path) {
                Storage::disk('public')->delete($logo->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logo', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($logo && $logo->favicon_path) {
                Storage::disk('public')->delete($logo->favicon_path);
            }
            $validated['favicon_path'] = $request->file('favicon')->store('logo', 'public');
        }

        if ($logo) {
            $logo->update($validated);
        } else {
            Logo::create([
                'logo_path' => $validated['logo_path'] ?? null,
                'favicon_path' => $validated['favicon_path'] ?? null
            ]);
        }

        return redirect()->route('admin.logo.edit')
            ->with('success', 'Logo updated successfully! 🎨');
    }
}