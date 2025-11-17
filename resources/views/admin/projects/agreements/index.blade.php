@extends('adminlte::page')

@section('title', 'Anlaşmalar')

@section('content_header')
    <h1>Anlaşmalar - Proje: {{ $project->name ?? $project->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.projects.agreements.create', ['project' => $project->id]) }}" class="btn btn-primary mb-3">Yeni Anlaşma</a>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Birim</th>
                        <th>Durum</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agreements as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ optional($a->unit)->unit_no }}</td>
                            <td>{{ $a->status }}</td>
                            <td>{{ $a->meeting_date }}</td>
                            <td>
                                <a href="{{ route('admin.projects.agreements.show', ['project' => $project->id, 'agreement' => $a->id]) }}" class="btn btn-sm btn-outline-secondary">Görüntüle</a>
                                <a href="{{ route('admin.projects.agreements.edit', ['project' => $project->id, 'agreement' => $a->id]) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                                <form action="{{ route('admin.projects.agreements.destroy', ['project' => $project->id, 'agreement' => $a->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Silinsin mi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $agreements->links() }}
        </div>
    </div>
@endsection
