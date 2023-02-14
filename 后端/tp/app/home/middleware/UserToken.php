<?php

namespace app\home\middleware;

use app\home\Token;
use Closure;
use think\Request;
use think\Response;
use think\response\Redirect;

class UserToken
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param Closure $next
     * @return Response|Redirect
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('jwtToken',"");
        $res = (new Token())->checkToken($token);
        if ($res['code'] != 200 ){
            return json($res);
        }

        $request->uid = $res['data']->uid;
        return $next($request);
    }
}