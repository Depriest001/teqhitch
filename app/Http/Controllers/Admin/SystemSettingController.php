<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\SystemInfo;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function edit()
    {
        $settings = SystemInfo::first();  // assuming single row
        return view('admin.system', compact('settings'));
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

    public function updateSocialLinks(Request $request)
    {
        $validated = $request->validate([
            'facebook'  => 'nullable|url',
            'twitter'   => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin'  => 'nullable|url',
            'youtube'   => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'whatsapp'  => 'nullable|url',
        ]);

        $system = SystemInfo::first(); // or however you fetch the singleton row

        $system->update([
            'social_links' => $validated,
        ]);

        return back()->with('success', 'Social links updated successfully.');
    }
    
    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'favicon'   => 'nullable|image|mimes:png,ico,jpg,jpeg,webp|max:1024',
        ]);

        $settings = SystemInfo::first();

        // --- Handle Site Logo ---
        if ($request->hasFile('site_logo')) {
            // 1. Delete old logo if it exists
            if ($settings->site_logo) {
                $oldLogoPath = base_path('../uploads/' . $settings->site_logo);
                if (file_exists($oldLogoPath) && is_file($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            // 2. Prepare the file
            $logoFile = $request->file('site_logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            
            // 3. Physical Destination: public_html/uploads/branding
            $physicalPath = base_path('../uploads/branding');

            // 4. Move the file
            $logoFile->move($physicalPath, $logoName);

            // 5. Save the string "branding/logo_123.png" to the database
            $settings->site_logo = 'branding/' . $logoName;
        }

        // --- Handle Favicon ---
        if ($request->hasFile('favicon')) {
            // 1. Delete old favicon if it exists
            if ($settings->favicon) {
                $oldFaviconPath = base_path('../uploads/' . $settings->favicon);
                if (file_exists($oldFaviconPath) && is_file($oldFaviconPath)) {
                    unlink($oldFaviconPath);
                }
            }

            // 2. Prepare the file
            $faviconFile = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
            
            // 3. Physical Destination: public_html/uploads/branding
            $physicalPath = base_path('../uploads/branding');

            // 4. Move the file
            $faviconFile->move($physicalPath, $faviconName);

            // 5. Save the string "branding/favicon_123.png" to the database
            $settings->favicon = 'branding/' . $faviconName;
        }

        $settings->save();

        return back()->with('success', 'Branding updated successfully!');
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
