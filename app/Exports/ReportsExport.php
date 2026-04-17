<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $role = auth()->user()->getRoleNames()->first();
        $query = Document::with('lead');

        if ($role == 'dealer') {
            $query->whereHas('lead', function($q) {
                $q->where('dealer_id', auth()->id());
            });
        }

        if ($this->request->status && $this->request->status != 'All') {
            $query->where('status', $this->request->status);
        }

        if ($this->request->lead_id && $this->request->lead_id != 'All') {
            $query->where('lead_id', $this->request->lead_id);
        }

        return $query->get()->map(function ($doc) {
            return [
                $doc->customer_name,
                optional($doc->lead)->lead_code ?? 'N/A',
                $doc->pan_path ? 'Yes' : 'No',
                $doc->aadhaar_path ? 'Yes' : 'No',
                $doc->bill_path ? 'Yes' : 'No',
                $doc->bank_path ? 'Yes' : 'No',
                $doc->geo_path ? 'Yes' : 'No',
                $doc->status,
                $doc->uploaded_date ? $doc->uploaded_date->format('d-m-Y') : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Lead Code',
            'PANCard',
            'Aadhaar',
            'Elec. Bill',
            'Bank Stmt',
            'Geo Photos',
            'Status',
            'Uploaded Date',
        ];
    }
}
