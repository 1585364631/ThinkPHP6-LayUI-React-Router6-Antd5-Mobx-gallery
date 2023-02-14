<?php

namespace app\admin\controller;

class Error
{
    public function __call($name, $arguments)
    {
        return json([
            'code'=>404,
            'msg'=>'当前控制器不存在！'
        ]);
    }
}