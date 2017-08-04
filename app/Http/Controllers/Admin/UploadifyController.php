<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UploadifyController extends Controller
{
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension; //文件名
            $path = $file -> move(base_path().'/uploads',$newName); //文件存储路径
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
