<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>İmport Geçmişi</title>
    <style>
        .status-badge {
            font-size: 0.8rem;
        }
        .progress-sm {
            height: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="bi bi-clock-history"></i> İmport Geçmişi
                        </h4>
                        <a href="{{ route('bulk-import.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-plus-circle"></i> Yeni İmport
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Başarı mesajı -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($imports->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Dosya Adı</th>
                                            <th>Durum</th>
                                            <th>İlerleme</th>
                                            <th>Toplam</th>
                                            <th>Başarılı</th>
                                            <th>Başarısız</th>
                                            <th>Tarih</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($imports as $import)
                                        <tr>
                                            <td>
                                                <i class="bi bi-file-earmark-excel text-success"></i>
                                                {{ $import->filename }}
                                            </td>
                                            <td>
                                                @if($import->status == 'pending')
                                                    <span class="badge bg-warning status-badge">
                                                        <i class="bi bi-clock"></i> Bekliyor
                                                    </span>
                                                @elseif($import->status == 'processing')
                                                    <span class="badge bg-info status-badge">
                                                        <i class="bi bi-arrow-repeat"></i> İşleniyor
                                                    </span>
                                                @elseif($import->status == 'completed')
                                                    <span class="badge bg-success status-badge">
                                                        <i class="bi bi-check-circle"></i> Tamamlandı
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger status-badge">
                                                        <i class="bi bi-exclamation-triangle"></i> Hata
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $percentage = $import->total_records > 0 
                                                        ? ($import->processed_records / $import->total_records) * 100 
                                                        : 0;
                                                @endphp
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar 
                                                        @if($import->status == 'completed') bg-success
                                                        @elseif($import->status == 'failed') bg-danger
                                                        @elseif($import->status == 'processing') bg-info
                                                        @else bg-warning
                                                        @endif"
                                                        role="progressbar"
                                                        style="width: {{ $percentage }}%"
                                                        aria-valuenow="{{ $percentage }}"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $import->total_records }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $import->successful_records }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">{{ $import->failed_records }}</span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $import->created_at->format('d.m.Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                @if($import->error_log)
                                                    <button type="button" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#errorModal{{ $import->id }}">
                                                        <i class="bi bi-exclamation-triangle"></i> Hata Detayı
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $imports->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <h5 class="text-muted mt-3">Henüz import işlemi yapılmamış</h5>
                                <p class="text-muted">
                                    İlk import işleminizi başlatmak için butona tıklayın.
                                </p>
                                <a href="{{ route('bulk-import.index') }}" class="btn btn-primary">
                                    <i class="bi bi-upload"></i> İmport Başlat
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal Templates -->
    @foreach($imports as $import)
        @if($import->error_log)
            <div class="modal fade" id="errorModal{{ $import->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Hata Detayları - {{ $import->filename }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto;">{{ $import->error_log }}</pre>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        @if($imports->whereIn('status', ['processing', 'pending'])->count() > 0)
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        @endif
    </script>
</body>
</html>
