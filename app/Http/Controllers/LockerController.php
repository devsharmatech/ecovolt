<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LockerDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\RouteHandle;

class LockerController extends Controller
{
    use RouteHandle;
    
    public function index(Request $request)
    {
        $role = $this->getRoutePrefix();
        $documents = LockerDocument::with('user')->latest()->get();
        return view($role .'.locker.index', compact('documents', 'role'));
    }

    public function create()
    {
        $role = $this->getRoutePrefix();
        $users = User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->get();
        return view($role .'.locker.create', compact('users', 'role'));
    }

    public function store(Request $request)
    {
        $role = $this->getRoutePrefix();
        $request->validate([
            'user_id' => 'required',
            'category' => 'required',
            'title' => 'required',
            'file' => 'required|file|max:10240', // 10MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('locker', 'public');
            
            LockerDocument::create([
                'user_id' => $request->user_id,
                'category' => $request->category,
                'title' => $request->title,
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $this->formatBytes($file->getSize())
            ]);
        }

        return redirect()->route($role .'.locker.index')->with('success', 'Document added to Digital Locker!');
    }

    public function destroy($id)
    {
        $doc = LockerDocument::findOrFail($id);
        if ($doc->file_path) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $doc->delete();
        return redirect()->back()->with('success', 'Document removed from Locker.');
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
