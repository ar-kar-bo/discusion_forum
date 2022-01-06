@extends('layouts.master')
@section('content')
<div class="card card-dark">
    <div class="card-body">
        <a href="{{$article->previousPageUrl()}}" class="btn btn-danger">Prev Posts</a>
        <a href="{{$article->nextPageUrl()}}" class="btn btn-danger float-right">Next Posts</a>
    </div>
</div>
<div class="card card-dark">
    <div class="card-body">
        <div class="row">
            <!-- Loop this -->
            @foreach ($article as $a)
            <div class="col-md-4 mt-2">
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top"
                        src="{{asset($a->image)}}"
                        alt="Card image cap">
                    <div class="card-body">
                        <h5 class="text-dark">{{$a->title}}</h5>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <i class="fas fa-heart text-warning">
                                </i>
                                <small class="text-muted">{{$a->like_count}}</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="far fa-comment text-dark"></i>
                                <small class="text-muted">{{$a->comment_count}}</small>
                            </div>
                            <div class="col-md-4 text-center">
                                <a href="{{url('/article/'.$a->slug)}}" class="badge badge-warning p-1">View</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


