<?php
declare (strict_types = 1);

namespace app\admin\controller;
use think\facade\Session;
use think\Request;

class Index
{
    public function index(): \think\response\View
    {
        return view();
    }

    public function api(Request $request){
        $url = "https://layui.gitee.io/v2/static/json/table/demo1.json?";
        foreach ($request->all() as $item=>$v) {
            $url .= "&${item}=${v}";
        }
        $html = file_get_contents($url);
        $data = json_decode($html);
        return json($data);
    }

    public function serverInfo(): \think\response\Json
    {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'PHP版本'=>PHP_VERSION,
            '数据库版本' => \think\facade\Db::query("select version() as ver")[0]['ver'],
            'ThinkPHP版本'=>\think\facade\App::version(),
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '获取服务器语言'=>$_SERVER['HTTP_ACCEPT_LANGUAGE'],
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
        );
        $data = '<table class="layui-table"><thead><tr><th>类型</th><th>参数</th></tr></thead><tbody>';
        foreach($info as $i => $j){
            $data .= "<tr><td style='word-break: break-all;'>${i}</td><td style='word-break: break-all;'>${j}</td></tr>";
        }
        $data .= '</tbody></table>';
        return echoJson(200,$data);
    }
}
