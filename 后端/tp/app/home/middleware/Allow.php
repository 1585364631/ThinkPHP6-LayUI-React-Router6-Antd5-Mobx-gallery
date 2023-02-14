<?php

namespace app\home\middleware;

use Closure;
use think\middleware\AllowCrossDomain;
use think\Request;
use think\Response;
use think\response\Redirect;

class Allow extends AllowCrossDomain
{
    protected $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, jwtToken',
    ];
}