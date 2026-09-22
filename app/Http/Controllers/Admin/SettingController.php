<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::current();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::current();

        $data = $request->validate([
            'site_name' => 'required|string|max:255',
            'favicon' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
            'header_logo' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
            'footer_logo' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
            'about_text' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'footer_text' => 'nullable|string',
        ]);

        if ($request->hasFile('header_logo')) {
            $data['header_logo'] = $request->file('header_logo')->store('settings', 'public');
        }

        if ($request->hasFile('footer_logo')) {
            $data['footer_logo'] = $request->file('footer_logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $settings->update($data);

        return back()->with('status', 'সেটিংস আপডেট হয়েছে');
    }
}
