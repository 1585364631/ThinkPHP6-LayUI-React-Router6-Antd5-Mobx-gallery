<?php
// 应用公共文件
function echoJson($code,$msg): \think\response\Json
{
    return json([
        'code'=>$code,
        'msg'=>$msg
    ]);
}

function getNowDateTime(): string
{
    return (new DateTime())->format('Y-m-d H:i:s');
}


function getUserNumber(): string
{
    $chars = "0123456789abcdefghijklmnopqrstuvwxyz";
    $username = "";
    for ( $i = 0; $i < 6; $i++ ){
        $username .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return base_convert(time() - 1420070400, 10, 36).$username;
}