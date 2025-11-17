@extends('adminlte::page')

@section('title', 'Admin Panel')

@section('content_header')
    <h1>Hoşgeldiniz, Yönetici</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p>Bu CRM yönetim panelidir.</p>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/adminlte.min.css">
@stop

@section('js')
    <script>console.log('Admin panel yüklendi');</script>
@stop
