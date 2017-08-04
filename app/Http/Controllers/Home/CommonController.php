<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Navs;
use App\Http\Model\Category;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        // 点击量最高的6篇文章
        $hot = Article::orderBy('article_views','desc')->take(6)->get();

        $navs = Category::where('category_pid',0)->get();
        $navs2 = Category::where('category_pid','!=',0)->get();
        View::share('navs',$navs);
        View::share('navs2',$navs2);
        View::share('hot',$hot);
    }
}
