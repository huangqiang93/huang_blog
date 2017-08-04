<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Article;
use App\Http\Model\Config;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Config::get('web_conf.web_status')==1) {
            //特别推荐文章
            $recom = Article::orderBy('article_views','desc')->take(6)->get();

            //热门标签
            $tag = Config::where('conf_name','article_tags')->first();
            $tag->conf_content = explode(',',$tag->conf_content);

            //推荐文章
            $hot = Article::where('article_views','>=',0)->orderBy(\DB::raw('RAND()'))->take(6)->get();

            //全部文章
            $all = Article::orderBy('article_addtime','desc')->paginate(8);

            //友情链接
            $links = Links::orderBy('links_order','asc')->get();

            return view('home.index',compact('recom','tag','hot','all','links'));
        }else{
            return view('errors.error');
        }
    }

    public function category($category_id)
    {
        $cate = Category::where('category_id',$category_id)->first();
        if ($cate->category_pid==0){
            $sub_cate = Category::where('category_pid',$cate->category_id)->get();
            foreach($sub_cate as $k=>$v){
                $arr[] =  $v->category_id;
            }
            if (isset($arr)) {
                $data = Article::whereIn('article_categoryid',$arr)->paginate(8);
            }else{
                $data = Article::where('article_categoryid',$category_id)->paginate(1);
            }
        }else{
            $data = Article::where('article_categoryid',$category_id)->paginate(1);
        }
        $hot = Article::where('article_categoryid',$category_id)->orderBy('article_views','desc')->get();
        $fresh = Article::orderBy('article_id','desc')->take(6)->get();
        return view('home.category',compact('data','cate','hot','fresh'));
    }

    public function article($article_id)
    {
        Article::where('article_id',$article_id)->increment('article_views');
        $article = Article::where('article_id',$article_id)->first();
        $prev_next['prev'] = Article::where('article_id','<',$article_id)->orderBy('article_id','desc')->select('article_id','article_title')->first();
        $prev_next['next'] = Article::where('article_id','>',$article_id)->orderBy('article_id','asc')->select('article_id','article_title')->first();
        $random = Article::orderByRaw('RAND()')->take(5)->get();
        return view('home.article',compact('article','random','prev_next'));
    }

    public function search()
    {
        $get = Input::get('keywords');
        $article = Article::where('article_title','like',"%$get%")->get();
        $keyword = $get;

        $recom = Article::orderBy('article_views','desc')->take(6)->get();
        return view('home.search',compact('article','recom','keyword'));
    }

    public function tags($tag)
    {
        $article = Article::where('article_tags',$tag)->get();
        $recom = Article::orderBy('article_views','desc')->take(6)->get();
        $keyword = $tag;
        return view('home.search',compact('article','recom','keyword'));
    }


}
