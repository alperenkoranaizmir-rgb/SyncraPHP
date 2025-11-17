@extends('adminlte::page')

@section('title', isset($unit) ? 'Birim Düzenle' : 'Yeni Birim')

@section('content_header')
    <h1>{{ isset($unit) ? 'Birim Düzenle' : 'Yeni Birim' }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($unit) ? route('admin.projects.units.update', ['project' => $project->id, 'unit' => $unit->id]) : route('admin.projects.units.store', ['project' => $project->id]) }}">
                @csrf
                @if(isset($unit)) @method('PUT') @endif

                <div class="form-group">
                    <label>Birim No</label>
                    <input type="text" name="unit_no" class="form-control" value="{{ old('unit_no', $unit->unit_no ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Tip</label>
                    <input type="text" name="unit_type" class="form-control" value="{{ old('unit_type', $unit->unit_type ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Alan (m²)</label>
                    <input type="number" step="0.01" name="area_m2" class="form-control" value="{{ old('area_m2', $unit->area_m2 ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="description" class="form-control">{{ old('description', $unit->description ?? '') }}</textarea>
                </div>

                <button class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.projects.units.index', ['project' => $project->id]) }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
@endsection
