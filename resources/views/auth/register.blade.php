@extends('layouts.master')
@section('content')
<div class="card card-dark">
    <div class="card-header bg-warning">
        <h3>Register</h3>
    </div>
    <div class="card-body">
        <form action="{{route('register')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="" class="text-white">Enter Name</label>
                <input type="text" name="name" class="form-control" placeholder="enter name">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Email</label>
                <input type="email" name="email" class="form-control" placeholder="enter email">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter Password</label>
                <input type="password" name="password" class="form-control" placeholder="enter password">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Choose Image</label>
                <input type="file" name="image" class="form-control" placeholder="choose image">
            </div>
            <input type="submit" value="Register" class="btn  btn-outline-warning">
        </form>
    </div>
</div>
@endsection
