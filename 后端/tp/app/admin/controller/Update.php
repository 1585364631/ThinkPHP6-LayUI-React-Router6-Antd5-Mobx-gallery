<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\Request;

class Update
{
    public function index()
    {
        $files = request()->file();
        try {
            validate(['image'=>'fileSize:10240|fileExt:jpg,jpeg,png,bmp'])
                ->check($files);
            $savename = [];
            foreach($files as $file) {
                $savename[] = \think\facade\Filesystem::disk('public')->putFile( 'topic', $file);
            }
            return json([
               'code'=>200,
               'msg'=>'上传成功',
               'data'=>[
                   'src'=>$savename[0]
               ]
            ]);
        } catch (\think\exception\ValidateException $e) {
            echo $e->getMessage();
            return echoJson(201,'上传失败');
        }
    }
}
