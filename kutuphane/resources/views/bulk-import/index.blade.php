@extends('books.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Toplu Import İşlemleri</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Yeni Import Başlat</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('bulk-import.create') }}" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Dosya Yükle ve Import Başlat
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Son Import İşlemleri</h4>
                </div>
                <div class="card-body">
                    @if($importHistory['success'] && count($importHistory['imports']) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Dosya Adı</th>
                                        <th>Tür</th>
                                        <th>Durum</th>
                                        <th>İlerleme</th>
                                        <th>Tarih</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($importHistory['imports'] as $import)
                                        <tr>
                                            <td>{{ $import['id'] }}</td>
                                            <td>{{ $import['file_name'] }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ ucfirst($import['import_type']) }}</span>
                                            </td>
                                            <td>
                                                @if($import['status'] === 'pending')
                                                    <span class="badge bg-warning">Bekliyor</span>
                                                @elseif($import['status'] === 'processing')
                                                    <span class="badge bg-info">İşleniyor</span>
                                                @elseif($import['status'] === 'completed')
                                                    <span class="badge bg-success">Tamamlandı</span>
                                                @else
                                                    <span class="badge bg-danger">Başarısız</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar" style="width: {{ $import['progress'] }}%">
                                                        {{ $import['progress'] }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $import['created_at'] }}</td>
                                            <td>
                                                <a href="{{ route('bulk-import.status', $import['id']) }}" class="btn btn-sm btn-outline-primary">
                                                    Detay
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Henüz import işlemi bulunmuyor.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
