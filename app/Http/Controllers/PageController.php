<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

    // public function byLanguage(Request $request,$slug)
    // {
    //     $language_id = Language::where('slug',$slug)->first()->id;
    //     $article = Article::withCount('like','comment')
    //     ->whereHas("language",function($q) use ($language_id){
    //         $q->where('language_id',$language_id);
    //     })->latest()->paginate(6);
    //     $article->appends($request->all());
    //     return view('index',compact('article'));
    // }

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
}
