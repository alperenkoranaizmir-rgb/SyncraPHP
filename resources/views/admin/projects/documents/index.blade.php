@extends('adminlte::page')

@section('title', 'Belgeler')

@section('content_header')
    <h1>Belgeler - Proje: {{ $project->name ?? $project->id }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.projects.documents.create', ['project' => $project->id]) }}" class="btn btn-primary mb-3">Belge Yükle</a>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tür</th>
                        <th>İlişki</th>
                        <th>Yükleyen</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($docs as $doc)
                        <tr>
                            <td>{{ $doc->id }}</td>
                            <td>{{ $doc->doc_type }}</td>
                            <td>{{ $doc->unit_id ? 'Birim:'.$doc->unit_id : ($doc->owner_id ? 'Sahip:'.$doc->owner_id : '') }}</td>
                            <td>{{ optional($doc->uploadedBy)->name }}</td>
                            <td>{{ $doc->uploaded_at }}</td>
                            <td>
                                @if($doc->file_path)
                                    <a href="{{ route('admin.projects.documents.download', ['project' => $project->id, 'document' => $doc->id]) }}" class="btn btn-sm btn-outline-success">İndir</a>
                                @endif
                                <form action="{{ route('admin.projects.documents.destroy', ['project' => $project->id, 'document' => $doc->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Silinsin mi?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $docs->links() }}
        </div>
    </div>
@endsection
