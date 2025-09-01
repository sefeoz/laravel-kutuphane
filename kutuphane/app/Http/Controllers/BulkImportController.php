<?php

namespace App\Http\Controllers;

use App\Services\BulkImportFacade;
use Illuminate\Http\Request;
use App\Http\Requests\BulkImportStoreRequest;
use App\Models\ImportHistory;
use Illuminate\Http\JsonResponse;

/**
 * Controller - Facade Pattern kullanarak basit import interface'i sağlar
 */
class BulkImportController extends Controller
{
    public function __construct(
        private BulkImportFacade $importFacade
    ) {}

    /**
     * Import form'unu göster
     */
    public function index()
    {
        $importHistory = $this->importFacade->getImportHistory(10);
        return view('bulk-import.index', compact('importHistory'));
    }

    /**
     * Import form'unu göster
     */
    public function create()
    {
        return view('bulk-import.create');
    }

    /**
     * File upload ve import başlat - Facade sayesinde çok basit!
     */
    public function store(BulkImportStoreRequest $request)
    {
        $data = $request->validated();

        // Facade pattern - Tek method ile tüm karmaşık import süreci!
        $result = $this->importFacade->importFromFile(
            file: $request->file('file'),
            type: $data['import_type'],
            options: $data['options'] ?? []
        );

        if ($result['success']) {
            return redirect()
                ->route('bulk-import.status', $result['import_id'])
                ->with('success', $result['message']);
        }

        return redirect()
            ->back()
            ->withInput()
            ->with('error', $result['message']);
    }

    /**
     * Import durumunu göster - Facade ile basit sorgulama
     */
    public function showStatus(ImportHistory $importHistory)
    {
        $status = $this->importFacade->getImportStatus($importHistory->id);
        
        if (!$status['success']) {
            return redirect()
                ->route('bulk-import.index')
                ->with('error', $status['message']);
        }

        $importId = $importHistory->id;
        return view('bulk-import.status', compact('status', 'importId'));
    }

    /**
     * AJAX - Import durumu
     */
    public function getStatus(ImportHistory $importHistory): JsonResponse
    {
        $status = $this->importFacade->getImportStatus($importHistory->id);
        return response()->json($status);
    }

    /**
     * Import geçmişi
     */
    public function history()
    {
        $history = $this->importFacade->getImportHistory(50);
        return view('bulk-import.history', compact('history'));
    }
}

/**
 * ÖNCE (Facade olmadan) - Controller çok karmaşık olurdu:
 * 
 * public function store(Request $request) {
 *     // 1. File validation logic (15+ satır)
 *     // 2. File storage logic (10+ satır)  
 *     // 3. Excel parsing logic (20+ satır)
 *     // 4. Data validation logic (15+ satır)
 *     // 5. ImportHistory creation (10+ satır)
 *     // 6. Job dispatching logic (10+ satır)
 *     // 7. Error handling logic (15+ satır)
 *     // TOPLAM: 95+ satır karmaşık kod!
 * }
 * 
 * SONRA (Facade ile) - Controller çok basit:
 * 
 * public function store(Request $request) {
 *     $result = $this->importFacade->importFromFile(...);
 *     return $result['success'] ? redirect()->with('success') : redirect()->with('error');
 *     // TOPLAM: 10 satır basit kod!
 * }
 */
