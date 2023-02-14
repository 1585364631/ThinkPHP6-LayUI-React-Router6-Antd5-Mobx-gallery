<?php
declare (strict_types = 1);

namespace app\admin\middleware;

use app\middleware\Response;
use think\facade\Session;
use think\facade\View;
use think\Request;
use think\response\Redirect;

class AdminUser
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure       $next
     * @return Response|Redirect
     */
    public function handle(Request $request, \Closure $next)
    {
        //
        $sess = $request->session('user',false);
        if($sess && $sess == Session::get('user',false)){
            $user = $request->session('user');
            View::assign('user',$user);
        }else{
            return redirect((string)url("login"));
        }
        return $next($request);
    }
}
