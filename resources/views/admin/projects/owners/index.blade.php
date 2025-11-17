@extends('adminlte::page')

@section('title', 'Sahipler')

@section('content_header')
    <h1>Sahipler - Proje: {{ $project->name ?? $project->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.projects.owners.create', ['project' => $project->id]) }}" class="btn btn-primary mb-3">Yeni Sahip</a>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>İsim</th>
                        <th>TC / Email</th>
                        <th>Telefon</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($owners as $owner)
                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td>{{ $owner->first_name }} {{ $owner->last_name }}</td>
                            <td>{{ $owner->tc_no ?? $owner->email }}</td>
                            <td>{{ $owner->phone_primary }}</td>
                            <td>
                                <a href="{{ route('admin.projects.owners.show', ['project' => $project->id, 'owner' => $owner->id]) }}" class="btn btn-sm btn-outline-secondary">Görüntüle</a>
                                <a href="{{ route('admin.projects.owners.edit', ['project' => $project->id, 'owner' => $owner->id]) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                <form action="{{ route('admin.projects.owners.destroy', ['project' => $project->id, 'owner' => $owner->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Silinsin mi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $owners->links() }}
        </div>
    </div>
@endsection
