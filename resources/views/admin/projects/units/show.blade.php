@extends('adminlte::page')

@section('title', 'Birim Detayı')

@section('content_header')
    <h1>Birim: {{ $unit->unit_no }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Birim No</dt>
                <dd class="col-sm-9">{{ $unit->unit_no }}</dd>

                <dt class="col-sm-3">Tip</dt>
                <dd class="col-sm-9">{{ $unit->unit_type }}</dd>

                <dt class="col-sm-3">Alan (m²)</dt>
                <dd class="col-sm-9">{{ $unit->area_m2 }}</dd>

                <dt class="col-sm-3">Açıklama</dt>
                <dd class="col-sm-9">{{ $unit->description }}</dd>
            </dl>
            <a href="{{ route('admin.projects.units.index', ['project' => $project->id]) }}" class="btn btn-secondary">Geri</a>
        </div>
    </div>
@endsection
