@extends('adminlte::page')

@section('title', 'Proje')

@section('content_header')
    <h1>Proje: {{ $project->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Başlangıç:</strong> {{ $project->start_date }}</p>
            <p><strong>Bitiş (tahmini):</strong> {{ $project->est_end_date }}</p>
            <p><strong>Toplam birim:</strong> {{ $project->total_units }}</p>

            <h4>Birimler</h4>
            <ul>
                @foreach($project->units as $unit)
                    <li>{{ $unit->name ?? '—' }}</li>
                @endforeach
            </ul>

            <h4>Sahipler</h4>
            <ul>
                @foreach($project->owners as $owner)
                    <li>{{ $owner->first_name }} {{ $owner->last_name }}</li>
                @endforeach
            </ul>

            <h4>Kararlar</h4>
            <ul>
                @foreach($project->decisions as $decision)
                    <li>{{ $decision->title }} — {{ $decision->status }}</li>
                @endforeach
            </ul>
            <div class="mt-3">
              <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning">Düzenle</a>
              <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" style="display:inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Silinsin mi?')">Sil</button>
              </form>

              <form method="POST" action="{{ url('/api/projects/'.$project->id.'/documents/export') }}" style="display:inline-block; margin-left:8px">
                @csrf
                <button class="btn btn-sm btn-secondary">Belgeleri ZIP olarak indir</button>
              </form>
            </div>
        </div>
    </div>
@stop
@extends('adminlte.base')

@section('title','Proje Detay')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>{{ $project->name }}</h1></div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <h5>Genel Bilgiler</h5>
          <p>Başlangıç: {{ $project->start_date }}</p>
          <p>Bitiş: {{ $project->est_end_date }}</p>

          <h5>İlerleme</h5>
          <p>Toplam birim: {{ $project->total_units }}</p>

          <h5>Birimler</h5>
          <ul>
            @foreach($project->units as $unit)
              <li>{{ $unit->unit_no }} - {{ $unit->usage_status }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
