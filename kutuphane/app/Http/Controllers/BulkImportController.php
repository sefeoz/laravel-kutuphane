<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportHistory;
use App\Jobs\ImportAuthorsJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BulkImportController extends Controller
{
    public function index() : View
    {
        return view('bulk-import.index');
    }

    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        
        $path = $file->store('imports');
        $fullPath = Storage::path($path);

        $importHistory = ImportHistory::create([
            'filename' => $originalName,
            'status' => 'pending',
            'total_records' => 0,
            'processed_records' => 0,
            'successful_records' => 0,
            'failed_records' => 0,
        ]);

        ImportAuthorsJob::dispatch($fullPath, $importHistory->id);

        return redirect()->route('bulk-import.history')
            ->with('success', 'Import işlemi başlatıldı. İşlem tamamlandığında bilgilendirileceksiniz.');
    }

    public function history() : View    
    {
        $imports = ImportHistory::orderBy('created_at', 'desc')->paginate(10);
        return view('bulk-import.history', compact('imports'));
    }

    public function show($id) : View
    {
        $import = ImportHistory::findOrFail($id);
        return view('bulk-import.show', compact('import'));
    }
}
