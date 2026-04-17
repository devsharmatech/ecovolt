<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LockerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LockerController extends Controller
{
    public function index()
    {
        $documents = LockerDocument::where('user_id', auth()->id())->latest()->get();
        
        $totalSize = LockerDocument::where('user_id', auth()->id())->sum(\DB::raw('CAST(file_size AS DECIMAL)')); 
        // Note: Summing formatted strings is complex, but for demo let's just return documents
        
        return response()->json([
            'status' => 'success',
            'data' => $documents,
            'summary' => [
                'total_files' => $documents->count(),
                'used_storage' => $this->getUsedStorage(auth()->id()),
                'total_storage' => '512 MB'
            ]
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required',
            'file' => 'required|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('locker', 'public');
            
            $doc = LockerDocument::create([
                'user_id' => auth()->id(),
                'category' => $request->category,
                'title' => $request->title,
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $this->formatBytes($file->getSize())
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'File uploaded successfully',
                'data' => $doc
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'File upload failed'], 400);
    }

    private function getUsedStorage($userId)
    {
        $documents = LockerDocument::where('user_id', $userId)->get();
        $totalBytes = 0;
        
        foreach ($documents as $doc) {
            // Convert formatted string back to bytes for calculation
            $sizeStr = $doc->file_size; // "2.4 MB"
            if (preg_match('/([\d.]+)\s*(\w+)/', $sizeStr, $matches)) {
                $val = (float)$matches[1];
                $unit = strtoupper($matches[2]);
                $units = ['B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4];
                $totalBytes += $val * pow(1024, $units[$unit] ?? 0);
            }
        }
        
        return $this->formatBytes($totalBytes);
    }

    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
