<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Model\Category;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //GET|admin/category 全部分类列表
    public function index()
    {
        $data = Category::orderBy('category_order','asc')->get();
        // dd($data);
        $categorys = (new Category)->getCategory($data);
        return view('admin.category_list')->with('data',$categorys);
    }

    public function changeorder()
    {
        $input=Input::all();
        $category = Category::find($input['category_id']);
        $category->category_order = $input['category_order'];
        $res = $category->update();
        if ($res) {
            $data = [
                'status'=>1,
                'msg'=>'排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'排序更新失败！'
            ];
        }
        return $data;
    }

    //GET|admin/category/create 添加分类页面
    public function create()
    {
        $data = Category::where('category_pid',0)->get();
        return view('admin.add_category')->with('data',$data);
    }

    //POST|admin/category  添加分类
    public function store()
    {
        $input = Input::except('_token');
        if ($input = Input::all()) {
            $rules = [
                'category_name'=>'required',
            ];
            $message = [
                'category_name.required'=>'分类名称不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if ($validator->passes()) {
                $res = Category::create($input);
                if ($res) {
                    $data = [
                        'status'=>1,
                        'msg'=>'添加分类成功！'
                    ];
                    return $data;
                }else{
                    $data = [
                        'status'=>0,
                        'msg'=>'添加分类失败！'
                    ];
                    return $data;
                }
            }else{
                $data = [
                    'status'=>0,
                    'msg'=>'分类名称不能为空！'
                ];
                return $data;
            }
        }
    }

    //GET|admin/category/{category}/edit 编辑分类页面
    public function edit($category_id)
    {
        $field = Category::find($category_id);
        $data = Category::orderBy('category_order','asc')->get();
        return view('admin.category_edit',compact('field','data'));
    }

    //PUT|PATCH  admin/category/{category} 更新分类
    public function update($category_id)
    {
        $input = Input::except('_method','_token');
        $res = Category::where('category_id',$category_id)->update($input);
        if ($res) {
            return redirect('admin/category');
        }else{
            return back()->with('errors','更新分类失败！');
        }

    }

    //DELETE|admin/category/{category}
    public function destroy($category_id)
    {
        $res = Category::where('category_id',$category_id)->delete();
        if ($res) {
            $data = [
                'status'=>1,
                'msg'=>'删除分类成功！'
            ];
            return $data;
        }else{
            $data = [
                'status'=>0,
                'msg'=>'删除分类失败！'
            ];
            return $data;
        }
    }

    //GET|admin/category/{category}
    public function show()
    {

    }


}
