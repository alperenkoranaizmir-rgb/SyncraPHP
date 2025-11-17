@extends('adminlte.base')

@section('title', 'Giriş')

@section('content')
<div class="login-box">
  <div class="login-logo"><a href="#"><b>Syncra</b> Admin</a></div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Oturum açmak için bilgilerinizi girin</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Şifre">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <div class="row">
          <div class="col-8"><a href="{{ url('/adminlte/register') }}">Kayıt ol</a></div>
          <div class="col-4"><button type="submit" class="btn btn-primary btn-block">Giriş</button></div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
