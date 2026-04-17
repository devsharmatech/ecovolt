<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CmsPage;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::all();
        return view('admin.cms.index', compact('pages'));
    }

    public function edit($id)
    {
        $page = CmsPage::findOrFail($id);
        // Decode JSON for editing
        $page->content_data = json_decode($page->content);
        return view('admin.cms.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);
        
        // Simplified update for now: just save the JSON content
        $page->update([
            'title' => $request->title,
            'content' => $request->content // Expecting JSON string from textarea for now, or build a form builder
        ]);

        return redirect()->route(auth()->user()->getRoleNames()->first() . '.cms.index')
            ->with('success', 'Page updated successfully');
    }
}
