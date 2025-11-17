@extends('adminlte::page')

@section('title', 'Birimler')

@section('content_header')
    <h1>Birimler - Proje: {{ $project->name ?? $project->title ?? $project->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.projects.units.create', ['project' => $project->id]) }}" class="btn btn-primary mb-3">Yeni Birim</a>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Birim No</th>
                        <th>Tip</th>
                        <th>Alan (m²)</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                        <tr>
                            <td>{{ $unit->id }}</td>
                            <td>{{ $unit->unit_no }}</td>
                            <td>{{ $unit->unit_type }}</td>
                            <td>{{ $unit->area_m2 }}</td>
                            <td>
                                <a href="{{ route('admin.projects.units.show', ['project' => $project->id, 'unit' => $unit->id]) }}" class="btn btn-sm btn-outline-secondary">Görüntüle</a>
                                <a href="{{ route('admin.projects.units.edit', ['project' => $project->id, 'unit' => $unit->id]) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                <form action="{{ route('admin.projects.units.destroy', ['project' => $project->id, 'unit' => $unit->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Silinsin mi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $units->links() }}
        </div>
    </div>
@endsection
