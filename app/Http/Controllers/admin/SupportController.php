<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SupportSetting;
use App\Models\Faq;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        $settings = SupportSetting::first() ?? new SupportSetting();
        $faqs = Faq::orderBy('order', 'asc')->get();
        return view('admin.support.index', compact('settings', 'faqs'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required',
            'helpline' => 'required',
            'email' => 'required|email',
        ]);

        $settings = SupportSetting::first();
        if (!$settings) {
            $settings = new SupportSetting();
        }
        $settings->fill($request->all());
        $settings->save();

        return back()->with('success', 'Support settings updated successfully!');
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create($request->all());

        return back()->with('success', 'FAQ added successfully!');
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq->update($request->all());

        return back()->with('success', 'FAQ updated successfully!');
    }

    public function destroyFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully!');
    }
}
