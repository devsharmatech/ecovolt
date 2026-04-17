<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class CmsController extends Controller
{
    public function getPage($slug)
    {
        $page = \App\Models\CmsPage::where('slug', $slug)->firstOrFail();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => $page->title,
                'content' => json_decode($page->content)
            ]
        ]);
    }

    public function downloadPdf($slug)
    {
        $page = \App\Models\CmsPage::where('slug', $slug)->firstOrFail();
        $content = json_decode($page->content);
        
        $pdf = Pdf::loadView('pdf.cms_page', compact('page', 'content'));
        
        return $pdf->download($slug . '.pdf');
    }
}
