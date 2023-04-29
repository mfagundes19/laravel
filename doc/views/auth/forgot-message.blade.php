<meta http-equiv="refresh" content="10; {{ route('login') }}">
@extends('layouts.index')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{url('/images/logo.jpg')}}" width="400">    
            </div>
            <div class="card">
                <div class="card-body login-card-body text-center pd-20" style="padding: 50px;">
                    <h3><?=$message?></h3>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
