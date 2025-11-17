@extends('adminlte::page')

@section('title', 'Projeler')

@section('content_header')
    <h1>Projeler</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ad</th>
                        <th>Tip</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->type }}</td>
                            <td>{{ $project->status }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-primary">Görüntüle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">{{ $projects->links() }}</div>
        </div>
    </div>
@stop
@extends('adminlte.base')

@section('title','Projeler')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h1>Projeler</h1></div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <table class="table table-striped">
            <thead><tr><th>ID</th><th>İsim</th><th>Status</th><th>Units</th><th>Yönet</th></tr></thead>
            <tbody>
              @foreach($projects as $project)
                <tr>
                  <td>{{ $project->id }}</td>
                  <td><a href="{{ route('admin.projects.show',$project->id) }}">{{ $project->name }}</a></td>
                  <td>{{ $project->status }}</td>
                  <td>{{ $project->total_units }}</td>
                  <td><a class="btn btn-sm btn-primary" href="{{ route('admin.projects.show',$project->id) }}">İncele</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
