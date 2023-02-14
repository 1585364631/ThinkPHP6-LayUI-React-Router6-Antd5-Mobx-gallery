<?php
use think\facade\Route;
Route::any('login','home/user/login')->name('homeLogin');
Route::any('register','home/user/register')->name('homeRegister');
Route::group("",function (){
    // 相册列表
    Route::any('photo', 'home/photo/index')->name('photoHome');
    // 图片列表
    Route::any('picture', 'home/picture/index')->name('pictureHome');
    // 图片上传
    Route::any('update','home/updateImage/index')->name('updateHome');
    Route::any('user','home/user/update')->name('homeUser');

    Route::any("checkLogin",'home/user/checkLogin')->name("homeCheckLogin");
})->middleware(\app\home\middleware\UserToken::class);

// 验证码路由
Route::get('captcha/[:config]','\\think\\captcha\\CaptchaController@index')->name('homeCaptcha');