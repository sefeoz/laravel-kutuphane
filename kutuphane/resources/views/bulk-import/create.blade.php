@extends('books.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Toplu Import - Dosya Yükle</h1>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Yeni Import Başlat</h4>
                </div>
                <div class="card-body">
                    <!-- Facade Pattern sayesinde çok basit form! -->
                    <form action="{{ route('bulk-import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="import_type" class="form-label">Import Türü</label>
                            <select name="import_type" id="import_type" class="form-control" required>
                                <option value="">Seçiniz</option>
                                <option value="author" {{ old('import_type') === 'author' ? 'selected' : '' }}>
                                    Yazar (Author)
                                </option>
                                <option value="book" {{ old('import_type') === 'book' ? 'selected' : '' }}>
                                    Kitap (Book)
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">Excel/CSV Dosyası</label>
                            <input type="file" name="file" id="file" class="form-control" 
                                   accept=".csv,.xlsx,.xls" required>
                            <div class="form-text">
                                Desteklenen formatlar: CSV, XLSX, XLS (Max: 5MB)
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="options[skip_duplicates]" 
                                       id="skip_duplicates" value="1" {{ old('options.skip_duplicates') ? 'checked' : '' }}>
                                <label class="form-check-label" for="skip_duplicates">
                                    Duplicate kayıtları atla
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="options[send_notification]" 
                                       id="send_notification" value="1" {{ old('options.send_notification') ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_notification">
                                    İşlem tamamlandığında email gönder
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Import Başlat
                            </button>
                            <a href="{{ route('bulk-import.index') }}" class="btn btn-secondary">
                                İptal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>CSV Dosya Formatı</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Yazar (Author) Format:</h6>
                            <pre class="bg-light p-2">name,bio,birth_date
John Doe,Ünlü yazar,1980-05-15
Jane Smith,Roman yazarı,1975-12-10</pre>
                        </div>
                        <div class="col-md-6">
                            <h6>Kitap (Book) Format:</h6>
                            <pre class="bg-light p-2">name,author,isbn,page_count
Kitap Adı,Yazar Adı,978-0123456789,350
Başka Kitap,Başka Yazar,978-9876543210,280</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
