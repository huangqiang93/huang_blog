<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id';
    protected $guarded = [];
    public $timestamps = false;

    public function getCategory($data)
    {
        $arr = array();
        foreach ($data as $key => $value) {
            if ($value->category_pid==0) {
                $arr[] = $data[$key];
                foreach ($data as $k => $v) {
                    if ($v->category_pid == $value->category_id) {
                        $data[$k]['category_name'] = '└─'.$data[$k]['category_name'];
                        $arr[] = $data[$k];
                    }
                }
            }
        }
        return $arr;
    }
}
