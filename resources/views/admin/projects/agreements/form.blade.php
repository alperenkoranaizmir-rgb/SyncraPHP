@extends('adminlte::page')

@section('title', isset($agreement) ? 'Anlaşma Düzenle' : 'Yeni Anlaşma')

@section('content_header')
    <h1>{{ isset($agreement) ? 'Anlaşma Düzenle' : 'Yeni Anlaşma' }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($agreement) ? route('admin.projects.agreements.update', ['project' => $project->id, 'agreement' => $agreement->id]) : route('admin.projects.agreements.store', ['project' => $project->id]) }}">
                @csrf
                @if(isset($agreement)) @method('PUT') @endif

                <div class="form-group">
                    <label>Birim (ID)</label>
                    <input type="text" name="unit_id" class="form-control" value="{{ old('unit_id', $agreement->unit_id ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Durum</label>
                    <input type="text" name="status" class="form-control" value="{{ old('status', $agreement->status ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Toplantı Tarihi</label>
                    <input type="datetime-local" name="meeting_date" class="form-control" value="{{ old('meeting_date', optional($agreement->meeting_date)->format('Y-m-d\TH:i') ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Notlar</label>
                    <textarea name="notes" class="form-control">{{ old('notes', $agreement->notes ?? '') }}</textarea>
                </div>

                <button class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.projects.agreements.index', ['project' => $project->id]) }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
@endsection
