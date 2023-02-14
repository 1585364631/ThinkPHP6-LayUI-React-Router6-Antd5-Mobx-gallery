<?php

namespace app\home\controller;

class Error
{
    public function index()
    {
        dd([
            'code'=>404,
            'msg'=>'当前控制器不存在！'
        ]);
    }
}