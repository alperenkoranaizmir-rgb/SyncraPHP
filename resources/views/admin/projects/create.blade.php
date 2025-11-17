@extends('adminlte::page')

@section('title', 'Yeni Proje')

@section('content_header')
    <h1>Yeni Proje Oluştur</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('admin.projects.store') }}">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Ad</label>
                    <input name="name" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Tip</label>
                    <input name="type" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Başlangıç</label>
                    <input type="date" name="start_date" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Bitiş (tahmini)</label>
                    <input type="date" name="est_end_date" class="form-control" />
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Oluştur</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Geri</a>
            </div>
        </div>
    </form>
@stop
