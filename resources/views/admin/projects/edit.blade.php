@extends('adminlte::page')

@section('title', 'Proje Düzenle')

@section('content_header')
    <h1>Proje Düzenle</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.projects.update', $project) }}">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Ad</label>
                    <input name="name" value="{{ old('name', $project->name) }}" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Tip</label>
                    <input name="type" value="{{ old('type', $project->type) }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Başlangıç</label>
                    <input type="date" name="start_date" value="{{ optional($project->start_date)->format('Y-m-d') }}" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Bitiş (tahmini)</label>
                    <input type="date" name="est_end_date" value="{{ optional($project->est_end_date)->format('Y-m-d') }}" class="form-control" />
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Güncelle</button>
                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary">Geri</a>
            </div>
        </div>
    </form>
@stop
