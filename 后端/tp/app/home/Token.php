<?php

namespace app\home;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token
{
    protected $salt;
    protected $keyId;

    public function __construct()
    {
        $this->salt = md5("1585364631");
    }

    function getToken($uid): string
    {
        $currentTime = time();
        return JWT::encode([
            "iss" => 'dao',
            "aud" => '',
            "iat" => $currentTime,
            "nbf" => $currentTime,
            "exp" => $currentTime + 3600 * 24,
            "data" => [
                'uid' => $uid,
            ]
        ], $this->salt, "HS256");
    }

    public function checkToken($token): array
    {
        $res = array("code"=>500);
        try {
            JWT::$leeway = 60;
            $decoded = JWT::decode($token, new Key($this->salt, 'HS256'));
            return [
                "code"=>200,
                "data"=>((array)$decoded)['data']
            ];
        } catch(\Firebase\JWT\SignatureInvalidException $e) {
            $res['msg']="签名不正确";
        }catch(\Firebase\JWT\BeforeValidException|\Firebase\JWT\ExpiredException $e) {
            $res['msg']="token失效";
        } catch(\Exception $e) {
            $res['msg']=$e->getMessage();
        }
        return $res;
    }
}