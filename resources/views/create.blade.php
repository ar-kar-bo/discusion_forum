@extends('layouts.master')
@section('content')
<div class="card card-dark">
    <div class="card-header">
        <h3>Create New Article</h3>
    </div>
    <div class="card-body">
        <form action="{{route('create-article')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="" class="text-white">Enter Title</label>
                <input type="name" name="title" class="form-control" placeholder="enter username">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Choose Category</label>
                <select name="category_id" id="" class="form-control">
                    @foreach ($category as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-check form-check-inline">
                @foreach ($language as $l)
                <span class="mr-2">
                    <input class="form-check-input" type="checkbox" name="language[]" value="{{$l->id}}" id="{{$l->id}}">
                    <label class="form-check-label" for="{{$l->id}}">{{$l->name}}</label>
                </span>
                @endforeach
            </div>
            <br><br>
            <div class="form-group">
                <label for="">Choose Image</label>
                <input type="file" class="form-control" name="image">
            </div>
            <div class="form-group">
                <label for="" class="text-white">Enter description</label>
                <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
            </div>
            <input type="submit" value="Create" class="btn  btn-outline-warning">
        </form>
    </div>
</div>
@endsection
