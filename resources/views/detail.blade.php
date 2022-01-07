@extends('layouts.master')
@section('content')
<div class="card card-dark">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-dark">
                    <div class="card-body">
                        <div class="row">
                            <!-- icons -->
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <i class="fas fa-heart text-warning" id="like">
                                        </i>
                                        <small class="text-muted" id="like_count">{{$article->like_count}}</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <i class="far fa-comment text-dark"></i>
                                        <small class="text-muted" id="comment_count">{{$article->comment_count}}</small>
                                    </div>

                                </div>
                            </div>
                            <!-- Icons -->

                            <!-- Category -->
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{url('/category/'.$article->category->slug)}}" class="badge badge-primary">{{$article->category->name}}</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Category -->


                            <!-- Language -->
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($article->language as $l)
                                        <a href="{{url('/language/'.$l->slug)}}" class="badge badge-success">{{$l->name}}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Language -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12">
            <h3>{{$article->title}}</h3>
            <p>
                {{$article->description}}
            </p>
        </div>

        <!-- Comments -->
        <div class="card card-dark">
            <div class="card-header">
                <h4>Comments</h4>
            </div>
            <div class="card-body">
                        <!-- create comment -->
                @auth
                <div class="card-dark md-1">
                    <div class="row">
                        <div class="col-md-10">
                            <textarea name="comment" id="comment" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <input type="button" value="Create" id="create_comment" class="btn btn-danger">

                        </div>
                    </div>
                </div>
                @endauth


                <!-- Loop Comment -->
                <div id="comment_list">
                    @foreach ($article->comment as $cmt)
                <div class="card-dark mt-1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-mt-1">
                                <img src="{{asset($cmt->user->image)}}"
                                    style="width:50px;border-radius:50%" alt="">
                            </div>
                            <div class="col-mt-4 d-flex align-items-center">
                                {{$cmt->user->name}}
                            </div>
                        </div>
                        <hr>
                        <p>{{$cmt->comment}}</p>
                    </div>
                </div>
                @endforeach
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

    <script>
        const like = document.querySelector('#like');
        const like_count = document.querySelector('#like_count');
        like.addEventListener('click',()=>{
            axios.get('/article/like/'+{{$article->id}})
            .then((res)=>{
                if(res.data.status == 'like'){
                    toastr.success('Like Success');
                }else{
                    toastr.warning('Unlike');
                }
                like_count.innerHTML = res.data.like_count;
            })
        });

        const comment = document.getElementById('comment');
        const comment_list = document.getElementById('comment_list');
        const create_comment = document.getElementById('create_comment');
        const comment_count = document.getElementById('comment_count');

        create_comment.addEventListener('click',()=>{
            const formData = new FormData();
            formData.append("comment",comment.value);
            formData.append("article_id","{{$article->id}}");
            axios.post('/comment/create',formData)
            .then(function(res){
                console.log(res.data.data);
                comment_list.innerHTML = res.data.data;
                comment_count.innerHTML = res.data.comment_count;
            })
        });
    </script>
@endsection

