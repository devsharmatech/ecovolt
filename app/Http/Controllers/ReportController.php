<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Lead;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use Illuminate\Support\Facades\DB;
use App\RouteHandle;

class ReportController extends Controller
{
    use RouteHandle;
    public function index(Request $request)
    {
        return $this->loadData($request);
    }

    public function filter(Request $request)
    {
        return $this->loadData($request);
    }

    private function loadData($request)
    {
        $role = auth()->user()->getRoleNames()->first();
        $query = Document::with('lead');

        // Filter by Dealer if role is dealer
        if ($role == 'dealer') {
            $query->whereHas('lead', function($q) {
                $q->where('dealer_id', auth()->id());
            });
        }

        // Filters
        // if ($request->filled('document_type') && $request->document_type != 'All') {
        //     $query->where('document_type', $request->document_type);
        // }

        if ($request->filled('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }

        if ($request->filled('lead_id') && $request->lead_id != 'All') {
            $query->where('lead_id', $request->lead_id);
        }

        $documents = $query->latest()->paginate(20);

        // Summary
        $summary = [
            'total_documents'   => $documents->total(),
            'verified_documents'=> Document::where('status','verified')->count(),
            'pending_documents' => Document::where('status','pending')->count(),
            'verification_rate' => Document::count() > 0
                ? round((Document::where('status','verified')->count() / Document::count()) * 100, 2)
                : 0,
        ];

        // Since documents are now columns (pan_path, etc), we use a standard list
        $documentTypes = ['PAN Card', 'Aadhaar Card', 'Electricity Bill', 'Bank Statement', 'Geo Photos'];
        $leads = ($role == 'dealer') ? Lead::where('dealer_id', auth()->id())->get() : Lead::all();

        return view($this->getRoutePrefix() .'.report.index', compact(
            'documents','summary','documentTypes','leads'
        ));
    }

    // ---------------- DOWNLOAD PDF ----------------
    public function downloadPdf(Request $request)
    {
        $role = auth()->user()->getRoleNames()->first();
        $query = Document::with('lead');
        
        if ($role == 'dealer') {
            $query->whereHas('lead', function($q) {
                $q->where('dealer_id', auth()->id());
            });
        }

        if ($request->filled('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('lead_id') && $request->lead_id != 'All') {
            $query->where('lead_id', $request->lead_id);
        }
        
        $documents = $query->latest()->get();
        
        $summary = [
            'total_documents'   => $documents->count(),
            'verified_documents'=> Document::where('status','verified')->count(),
            'pending_documents' => Document::where('status','pending')->count(),
            'verification_rate' => Document::count() > 0
                ? round((Document::where('status','verified')->count() / Document::count()) * 100, 2)
                : 0,
        ];
        
        $requestData = $request->all();
        
        $pdf = Pdf::loadView($this->getRoutePrefix() . '.report.pdf', compact(
            'documents', 'summary', 'requestData'
        ));
        
        return $pdf->download('documents-report-' . date('Y-m-d') . '.pdf');
    }

    // ---------------- DOWNLOAD EXCEL ----------------
    public function downloadExcel(Request $request)
    {
        return Excel::download(
            new ReportsExport($request),
            'documents-report.xlsx'
        );
    }
}
