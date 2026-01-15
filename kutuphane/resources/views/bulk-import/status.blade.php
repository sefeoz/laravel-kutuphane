@extends('books.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1>Import Durumu #{{ $importId }}</h1>
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Import İşlemi Detayları</h4>
                    <span class="badge bg-{{ $status['status'] === 'completed' ? 'success' : ($status['status'] === 'failed' ? 'danger' : 'info') }} fs-6">
                        {{ ucfirst($status['status']) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>İlerleme:</strong>
                            <div class="progress mt-2">
                                <div class="progress-bar progress-bar-striped {{ $status['status'] === 'processing' ? 'progress-bar-animated' : '' }}" 
                                     style="width: {{ $status['progress'] }}%">
                                    {{ $status['progress'] }}%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-6">Toplam Kayıt:</dt>
                                <dd class="col-sm-6">{{ number_format($status['total_records']) }}</dd>
                                
                                <dt class="col-sm-6">İşlenen:</dt>
                                <dd class="col-sm-6">{{ number_format($status['processed_records']) }}</dd>
                                
                                <dt class="col-sm-6">Başarılı:</dt>
                                <dd class="col-sm-6 text-success">{{ number_format($status['successful_records']) }}</dd>
                                
                                <dt class="col-sm-6">Başarısız:</dt>
                                <dd class="col-sm-6 text-danger">{{ number_format($status['failed_records']) }}</dd>
                            </dl>
                        </div>
                    </div>

                    @if($status['error_log'])
                        <div class="alert alert-danger">
                            <h6>Hatalar:</h6>
                            <pre class="mb-0">{{ $status['error_log'] }}</pre>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('bulk-import.index') }}" class="btn btn-secondary">
                            Import Listesi
                        </a>
                        @if($status['status'] === 'processing')
                            <button type="button" class="btn btn-primary" onclick="refreshStatus()">
                                <i class="fas fa-refresh"></i> Yenile
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($status['status'] === 'processing')
<script>
// Auto refresh for processing imports
setInterval(function() {
    fetch('{{ route("bulk-import.status-api", $importId) }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update progress bar
                const progressBar = document.querySelector('.progress-bar');
                progressBar.style.width = data.progress + '%';
                progressBar.textContent = data.progress + '%';
                
                // Update stats
                document.querySelectorAll('dd')[1].textContent = new Intl.NumberFormat().format(data.processed_records);
                document.querySelectorAll('dd')[2].textContent = new Intl.NumberFormat().format(data.successful_records);
                document.querySelectorAll('dd')[3].textContent = new Intl.NumberFormat().format(data.failed_records);
                
                // Reload page if completed
                if (data.status === 'completed' || data.status === 'failed') {
                    location.reload();
                }
            }
        })
        .catch(error => console.error('Error:', error));
}, 3000); // 3 saniyede bir kontrol et

function refreshStatus() {
    location.reload();
}
</script>
@endif
@endsection
