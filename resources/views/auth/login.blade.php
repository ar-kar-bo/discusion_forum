@extends('layouts.master')
@section('content')
<div class="card card-dark">
    <div class="card-header bg-warning">
        <h3>Login</h3>
    </div>
    <div class="card-body">
        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="" class="text-white">Enter Email</label>
                <input type="name" name="email" class="form-control" placeholder="enter email">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter password">
            </div>
            <input type="submit" value="Login" class="btn  btn-outline-warning">
        </form>
    </div>
</div>
@endsection
