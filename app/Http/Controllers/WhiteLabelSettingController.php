<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WhiteLabelSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\RouteHandle;

class WhiteLabelSettingController extends Controller
{
    use RouteHandle;
    
    public function manage()
    {
        $user = auth()->user();
      
        // $tenantId = $user->tenant_id;
        
        $settings = WhiteLabelSetting::firstOrCreate(
            ['tenant_id' => 1],
            [
                'primary_color' => '#007bff',
                'secondary_color' => '#6c757d',
            ]
        );

        return view($this->getRoutePrefix() .'.settings.manage', compact('settings'));
    }

    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo_url' => 'nullable|url|max:500',
            'primary_color' => 'nullable|string|max:20',
            'secondary_color' => 'nullable|string|max:20',
            'subdomain_prefix' => 'nullable|string|max:50|alpha_dash',
            'welcome_email_template' => 'nullable|string|max:500',
            'password_reset_email_template' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get tenant_id from authenticated user with validation
        $user = auth()->user();
        
        
        // Update or create settings
        WhiteLabelSetting::updateOrCreate(
            ['tenant_id' => 1],
            $request->only([
                'logo_url',
                'primary_color',
                'secondary_color',
                'subdomain_prefix',
                'welcome_email_template',
                'password_reset_email_template',
            ])
        );

        return redirect()->route($this->getRoutePrefix() .'.settings.manage')
            ->with('success', 'White-label settings updated successfully!');
    }
}