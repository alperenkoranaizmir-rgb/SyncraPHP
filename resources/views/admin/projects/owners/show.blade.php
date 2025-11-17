@extends('adminlte::page')

@section('title', 'Sahip Detayı')

@section('content_header')
    <h1>{{ $owner->first_name }} {{ $owner->last_name }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">İsim</dt>
                <dd class="col-sm-9">{{ $owner->first_name }} {{ $owner->last_name }}</dd>
                <dt class="col-sm-3">TC</dt>
                <dd class="col-sm-9">{{ $owner->tc_no }}</dd>
                <dt class="col-sm-3">Telefon</dt>
                <dd class="col-sm-9">{{ $owner->phone_primary }}</dd>
                <dt class="col-sm-3">Adres</dt>
                <dd class="col-sm-9">{{ $owner->address }}</dd>
            </dl>
            <a href="{{ route('admin.projects.owners.index', ['project' => $project->id]) }}" class="btn btn-secondary">Geri</a>
        </div>
    </div>
@endsection
