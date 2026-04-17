<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Carbon\Carbon;

class LeadsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, WithChunkReading
{
    use SkipsErrors;
    
    private $importType;
    private $importedCount = 0;
    private $updatedCount = 0;
    private $skippedCount = 0;

    public function __construct($importType = 'create')
    {
        $this->importType = $importType;
    }

    public function model(array $row)
    {
        // Map column names from Excel to database fields
        $leadData = [
            'local_name' => $row['lead_name'] ?? $row['local_name'] ?? null,
            'company' => $row['company'] ?? null,
            'status' => $row['status'] ?? 'Open',
            'owner' => $row['owner'] ?? auth()->user()->name,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'created_date' => $row['created_date'] ?? Carbon::now()->format('Y-m-d'),
            'description' => $row['description'] ?? null,
        ];

        // Remove null values
        $leadData = array_filter($leadData, function($value) {
            return !is_null($value);
        });

        if ($this->importType === 'create') {
            $this->importedCount++;
            return new Lead($leadData);
        } elseif ($this->importType === 'update') {
            // Update existing leads based on email or company name
            $lead = Lead::where('email', $leadData['email'] ?? '')
                        ->orWhere('company', $leadData['company'] ?? '')
                        ->first();
            
            if ($lead) {
                $lead->update($leadData);
                $this->updatedCount++;
                return null; // Don't create new model for updates
            } else {
                $this->importedCount++;
                return new Lead($leadData);
            }
        } else {
            // Replace mode - delete all and create new
            Lead::truncate();
            $this->importedCount++;
            return new Lead($leadData);
        }
    }

    public function rules(): array
    {
        return [
            '*.local_name' => 'required|string|max:255',
            '*.company' => 'required|string|max:255',
            '*.status' => 'nullable|string|max:255',
            '*.owner' => 'nullable|string|max:255',
            '*.email' => 'nullable|email|max:255',
            '*.phone' => 'nullable|string|max:20',
        ];
    }

    public function chunkSize(): int
    {
        return 100; // Process 100 rows at a time
    }

    // Getters for import statistics
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }
}