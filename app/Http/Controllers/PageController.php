<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleLike;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if($request->search)
        {
            $article = Article::withCount('like','comment')->where('title','like',"%{$request->search}%")->latest()->paginate(6);
        }else{
            $article = Article::withCount('like','comment')->latest()->paginate(6);
        }
        $article->appends($request->all());
        return view('index',compact('article'));
    }

    public function byCategory(Request $request,$slug)
    {
        $category_id = Category::where('slug',$slug)->first()->id;
        $article = Article::where('category_id',$category_id)->withCount('like','comment')->latest()->paginate(6);
        $article->appends($request->all());
        return view('index',compact('article'));
    }

    public function byLanguage(Request $request,$slug)
    {
        $language_id = Language::where('slug',$slug)->first()->id;
        $article = Article::withCount('like','comment')
        ->whereHas("language",function($q) use ($language_id){
            $q->where('language_id',$language_id);
        })->latest()->paginate(6);
        $article->appends($request->all());
        return view('index',compact('article'));
    }

    public function byLiked()
    {
        $user_id = Auth::user()->id;

        $article = Article::whereHas("like",function($q) use ($user_id){
            $q->where('user_id',$user_id);
        })->latest()->paginate(6);
        $article->appends(request()->all());
        return view('index',compact('article'));
    }

    public function detail($slug)
    {
        $article = Article::where('slug',$slug)->withCount('like','comment')->with('category','language','comment.user')->latest()->first();
        return view('detail',compact('article'));
    }

    public function createArticle()
    {
        $category = Category::all();
        $language = Language::all();
        return view('create',compact('category','language'));
    }

    public function postArticle(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'category_id'=>'required',
            'image'=>'required',
            'description'=>'required',
        ]);

        $image = $request->file('image');
        $image_name = uniqid(time()).$image->getClientOriginalName();
        $image_path = 'image/'.$image_name;
        $image->storeAs('image',$image_name);

        $article = Article::create([
            'user_id'=>Auth::user()->id,
            'category_id'=>$request->category_id,
            'title'=>$request->title,
            'slug'=>uniqid(time()).Str::slug($request->title),
            'image'=>$image_path,
            'description'=>$request->description
        ]);

        Article::find($article->id)->language()->sync($request->language);

        return redirect()->back()->with('success','Article Created Success!');
    }

    public function like($id)
    {
        $user_id = Auth::user()->id;
        $article_id = $id;
        $likeExist = ArticleLike::where('user_id',$user_id)->where('article_id',$article_id)->first();
        if($likeExist){
            ArticleLike::where('user_id',$user_id)->where('article_id',$article_id)->delete();
            $status = 'unlike';
        }else{
            ArticleLike::create([
                'user_id'=>$user_id,
                'article_id'=>$article_id
            ]);
            $status = 'like';
        }
        $like_count = ArticleLike::where('article_id',$article_id)->count();
        return response()->json(['like_count'=>$like_count,'status'=>$status]);
    }

    public function createComment(Request $request)
    {
        $comment = $request->comment;
        $article_id = $request->article_id;
        $user_id = Auth::user()->id;
        ArticleComment::create([
            'article_id'=>$article_id,
            'user_id'=>$user_id,
            'comment'=>$comment
        ]);
        $comments = ArticleComment::where('article_id',$article_id)->with('user')->latest()->get();
        $data = "";
        foreach($comments as $cmt){
            $asset = asset($cmt->user->image);
            $data.="<div class='card-dark mt-1'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-mt-1'>
                        <img src='{$asset}'
                            style='width:50px;border-radius:50%'>
                    </div>
                    <div class='col-mt-4 d-flex align-items-center'>
                        {$cmt->user->name}
                    </div>
                </div>
                <hr>
                <p>{$cmt->comment}</p>
            </div>
        </div>";
        }
        return response()->json(['data'=>$data]);

    }

}
