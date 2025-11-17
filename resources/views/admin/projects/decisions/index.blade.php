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
                        <th>% İmzalanma</th>
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
                            <td style="min-width:180px;">
                                <div class="progress" style="height:18px;">
                                  <div class="progress-bar" role="progressbar" style="width: {{ round($d->percentage) }}%;" aria-valuenow="{{ round($d->percentage) }}" aria-valuemin="0" aria-valuemax="100">{{ round($d->percentage,1) }}%</div>
                                </div>
                                <small>{{ $d->signed_shares }} / {{ $d->total_shares }} pay</small>
                            </td>
                            <td>{{ optional($d->creator)->name }}</td>
                            <td>{{ $d->created_at }}</td>
                            <td>
                                <a href="{{ route('admin.projects.decisions.show', ['project' => $projectId, 'decision' => $d->id]) }}" class="btn btn-sm btn-outline-primary">Detay</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
