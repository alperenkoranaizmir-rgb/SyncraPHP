@extends('adminlte::page')

@section('title', 'Anlaşma Detayı')

@section('content_header')
    <h1>Anlaşma #{{ $agreement->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Birim</dt>
                <dd class="col-sm-9">{{ optional($agreement->unit)->unit_no }}</dd>
                <dt class="col-sm-3">Durum</dt>
                <dd class="col-sm-9">{{ $agreement->status }}</dd>
                <dt class="col-sm-3">Toplantı Tarihi</dt>
                <dd class="col-sm-9">{{ $agreement->meeting_date }}</dd>
            </dl>
            <a href="{{ route('admin.projects.agreements.index', ['project' => $project->id]) }}" class="btn btn-secondary">Geri</a>
        </div>
    </div>
@endsection
