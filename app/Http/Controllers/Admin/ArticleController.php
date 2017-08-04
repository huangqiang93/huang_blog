<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Category;
use App\Http\Model\Article;
use App\Http\Model\Config;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::orderBy('article_id','desc')->paginate(10);
        return view('admin.article_list')->with('data',$data);
    }

    public function create()
    {
        $data = Category::orderBy('category_order','asc')->get();
        $categorys = (new Category)->getCategory($data);
        $tags = Config::where('conf_name','article_tags')->first();
        $tags->conf_content = explode(',',$tags->conf_content);
        return view('admin.article_add',compact('data','tags'));
    }

    public function store()
    {
        if ($input = Input::all()) {
            $input = Input::except('_token');
            $input['article_addtime']= time();
            $rules = [
                'article_title'=>'required',
                'article_content'=>'required',
            ];
            $message = [
                'article_title.required'=>'文章标题不能为空！',
                'article_content.required'=>'文章内容不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $res = Article::create($input);
                if ($res) {
                    return redirect('admin/article');
                }else{
                    return back()->with('errors','添加文章失败，请稍后重试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
    }

    public function edit($article_id)
    {
        $field = Article::find($article_id);
        $data = Category::orderBy('category_order','asc')->get();
        $data = (new Category)->getCategory($data);
        return view('admin.article_edit',compact('field','data'));
    }

    public function update($article_id)
    {
        $input = Input::except('_method','_token');
        $res = Article::where('article_id',$article_id)->update($input);
        if ($res) {
            return redirect('admin/article');
        }else{
            return back()->with('errors','编辑文章失败！');
        }
    }

    //DELETE|admin/category/{category}
    public function destroy($article_id)
    {
        $res = Article::where('article_id',$article_id)->delete();
        if ($res) {
            $data = [
                'status'=>1,
                'msg'=>'删除文章成功！'
            ];
            return $data;
        }else{
            $data = [
                'status'=>0,
                'msg'=>'删除文章失败！'
            ];
            return $data;
        }
    }
}
