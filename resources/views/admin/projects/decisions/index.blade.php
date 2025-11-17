@extends('adminlte::page')

@section('title', 'Projeye Ait Kararlar')

@section('content_header')
    <h1>Projeye Ait Kararlar</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('admin.projects.decisions.create', ['project' => $projectId]) }}" class="btn btn-primary mb-3">Yeni Karar Ekle</a>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Başlık</th>
                        <th>Durum</th>
                        <th>Oluşturan</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($decisions as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->title }}</td>
                            <td>{{ $d->status }}</td>
                            <td>{{ optional($d->creator)->name }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Detay</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
