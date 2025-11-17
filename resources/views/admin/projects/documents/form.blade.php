@extends('adminlte::page')

@section('title', 'Belge Yükle')

@section('content_header')
    <h1>Belge Yükle</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.projects.documents.store', ['project' => $project->id]) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>Tür</label>
                    <input type="text" name="doc_type" class="form-control" value="{{ old('doc_type') }}">
                </div>

                <div class="form-group">
                    <label>Dosya</label>
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="form-group">
                    <label>İlişki (Unit ID / Owner ID / Agreement ID)</label>
                    <input type="text" name="unit_id" class="form-control" placeholder="unit_id" value="{{ old('unit_id') }}">
                </div>

                <button class="btn btn-primary">Yükle</button>
                <a href="{{ route('admin.projects.documents.index', ['project' => $project->id]) }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
@endsection
