<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportSetting;
use App\Models\Faq;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $settings = SupportSetting::first();
        $faqs = Faq::where('is_active', true)->orderBy('order', 'asc')->get();

        return response()->json([
            'settings' => $settings,
            'faqs' => $faqs
        ]);
    }
}
