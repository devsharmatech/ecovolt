<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeadsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $status;

    public function __construct($status = 'all')
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Lead::query();
        
        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }
        
        return $query->orderBy('created_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Lead Name',
            'Company',
            'Status',
            'Owner',
            'Email',
            'Phone',
            'Created Date',
            'Last Updated',
            'Description'
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->local_name,
            $lead->company,
            $lead->status,
            $lead->owner,
            $lead->email ?? '',
            $lead->phone ?? '',
            $lead->created_date,
            $lead->updated_at->format('Y-m-d H:i:s'),
            $lead->description ?? '',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Style the header row
            'A1:J1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE0E0E0']
                ]
            ],
        ];
    }
}