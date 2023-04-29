@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{url('/images/logo.jpg')}}" width="400">    
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Seja bem-vindo</p>
                    <form method="POST" action="{{ route('users/forget-password') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required autofocus value="admin@localhost.com">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Senha" value="123456">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_repeat" id="password_repeat" class="form-control" placeholder="Repita sua Senha" value="123456">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                        </div>
                    </div>
                    </form>
                    <br>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
