@extends('adminlte::page')

@section('title', isset($owner) ? 'Sahip Düzenle' : 'Yeni Sahip')

@section('content_header')
    <h1>{{ isset($owner) ? 'Sahip Düzenle' : 'Yeni Sahip' }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($owner) ? route('admin.projects.owners.update', ['project' => $project->id, 'owner' => $owner->id]) : route('admin.projects.owners.store', ['project' => $project->id]) }}">
                @csrf
                @if(isset($owner)) @method('PUT') @endif

                <div class="form-group">
                    <label>İsim</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $owner->first_name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>Soyisim</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $owner->last_name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label>TC No</label>
                    <input type="text" name="tc_no" class="form-control" value="{{ old('tc_no', $owner->tc_no ?? '') }}">
                </div>

                <div class="form-group">
                    <label>Telefon</label>
                    <input type="text" name="phone_primary" class="form-control" value="{{ old('phone_primary', $owner->phone_primary ?? '') }}">
                </div>

                <button class="btn btn-primary">Kaydet</button>
                <a href="{{ route('admin.projects.owners.index', ['project' => $project->id]) }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
@endsection
