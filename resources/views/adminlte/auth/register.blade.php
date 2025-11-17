@extends('adminlte.base')

@section('title', 'Kayıt Ol')

@section('content')
<div class="register-box">
  <div class="register-logo"><a href="#"><b>Syncra</b></a></div>
  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Yeni hesap oluştur</p>
      <form action="#" method="post">
        <div class="input-group mb-3"><input type="text" class="form-control" placeholder="Ad Soyad"></div>
        <div class="input-group mb-3"><input type="email" class="form-control" placeholder="Email"></div>
        <div class="input-group mb-3"><input type="password" class="form-control" placeholder="Şifre"></div>
        <div class="row"><div class="col-8"><a href="{{ url('/adminlte/login') }}">Zaten üyeyim</a></div><div class="col-4"><button type="submit" class="btn btn-primary btn-block">Kayıt</button></div></div>
      </form>
    </div>
  </div>
</div>
@endsection
