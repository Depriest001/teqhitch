<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\SystemInfo;
use App\Models\EmailSetting;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function edit()
    {
        $settings = SystemInfo::first();  // assuming single row
        $email = EmailSetting::first();
        return view('admin.system', compact('settings', 'email'));
    }
    
    public function updateinfo(Request $request)
    {
        $request->validate([
            'site_name'      => 'required|string|max:255',
            'support_email'  => 'nullable|email',
            'support_phone'  => 'nullable|string|max:50',
            'address'        => 'nullable|string',
            'timezone'       => 'required|string',
        ]);

        $settings = SystemInfo::first();

        $settings->update([
            'site_name'     => $request->site_name,
            'support_email' => $request->support_email,
            'support_phone' => $request->support_phone,
            'address'       => $request->address,
            'timezone'      => $request->timezone,
        ]);

        return back()->with('success', 'System settings updated successfully!');
    }
    
    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon'   => 'nullable|image|mimes:png,ico,jpg,jpeg,webp|max:1024',
        ]);

        $settings = SystemInfo::first();

        if ($request->hasFile('site_logo')) {
            if ($settings->site_logo && Storage::disk('public')->exists($settings->site_logo)) {
                Storage::disk('public')->delete($settings->site_logo);
            }

            $settings->site_logo = $request->file('site_logo')
                ->store('branding', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }

            $settings->favicon = $request->file('favicon')
                ->store('branding', 'public');
        }

        $settings->save();

        return back()->with('success', 'Branding updated successfully!');
    }

    public function updatemail(Request $request)
    {
        $request->validate([
            'mail_driver'   => 'required|string|max:50',
            'host'          => 'required|string|max:255',
            'port'          => 'required|integer',
            'encryption'    => 'nullable|in:ssl,tls',
            'username'      => 'nullable|string|max:255',
            'password'      => 'nullable|string|max:255',
            'from_address'  => 'nullable|email',
            'from_name'     => 'nullable|string|max:255',
            'is_active'     => 'nullable|boolean',
        ]);

        $settings = EmailSetting::first();

        $data = $request->only([
            'mail_driver',
            'host',
            'port',
            'username',
            'encryption',
            'from_address',
            'from_name',
        ]);

        // Checkbox handling
        $data['is_active'] = $request->has('is_active');

        // Only update password if entered
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $settings->update($data);

        return back()->with('success', 'Email settings updated successfully!');
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about' => 'nullable|string',
        ]);

        $settings = SystemInfo::first();

        $settings->update([
            'about' => $request->about,
        ]);

        return back()->with('success', 'About information updated successfully!');
    }



}
