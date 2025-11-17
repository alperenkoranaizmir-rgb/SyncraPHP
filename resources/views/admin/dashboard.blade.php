@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1>Hoşgeldiniz, Yönetici</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Project::count() }}</h3>
                    <p>Toplam Proje</p>
                </div>
                <div class="icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <a href="{{ url('admin/projects') }}" class="small-box-footer">Detaylar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Kullanıcılar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ url('admin/users') }}" class="small-box-footer">Yönet <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ \App\Models\Document::count() }}</h3>
                    <p>Belgeler</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="#" class="small-box-footer">Gözat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\Decision::where('status','tamamlandi')->count() }}</h3>
                    <p>Tamamlanan Kararlar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <a href="#" class="small-box-footer">Detaylar <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Son Projeler</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ad</th>
                        <th>Durum</th>
                        <th>Oluşturulma</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Project::latest()->limit(8)->get() as $p)
                        <tr>
                            <td>{{ $p->getKey() }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->status ?? '-' }}</td>
                            <td>{{ $p->created_at?->format('Y-m-d') ?? '-' }}</td>
                            <td><a href="{{ url('admin/projects/'.$p->getKey()) }}" class="btn btn-sm btn-primary">Aç</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
    <script>console.log('Admin panel yüklendi');</script>
@stop
