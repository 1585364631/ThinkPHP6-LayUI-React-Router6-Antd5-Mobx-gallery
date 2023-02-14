<?php
use think\facade\Route;

// 登入和退出视图路由
Route::get('/login','admin/admin/index')->name('login');
Route::get('/logout','admin/admin/log_out_in')->name('logout');
// layui表格数据测试接口
Route::get('/apiapi','admin/index/api')->name('apiapi');

// 管理系统路由
Route::group('',function (){
    Route::get('/','admin/index/index')->name('index');
})->middleware(\app\admin\middleware\AdminUser::class);

// 接口路由
Route::group('api',function (){
    // 登入和退出路由
    Route::post('login','admin/admin/login')->name('loginApi');
    Route::any('logout','admin/admin/logout')->name('logoutApi');

    // 功能接口
    Route::group('',function (){
        // 系统信息路由
        Route::any('serverinfo','admin/index/serverinfo')->name('serverinfo');

        // 管理员账号密码操作路由
        Route::group('admin',function (){
            Route::post('resetUserName', 'admin/admin/resetUserName')->name('resetUserName');
            Route::post('resetPassword', 'admin/admin/resetPassword')->name('resetPassword');
        });

        // 用户列表
        Route::any('user', 'admin/user/index')->name('userApi');

        // 相册列表
        Route::any('photoAlbum', 'admin/photoalbums/index')->name('photoAlbumApi');

        // 图片列表
        Route::any('picture', 'admin/picture/index')->name('pictureApi');

        // 图片上传
        Route::any('update','admin/update/index')->name('updateImage');

    })->middleware(\app\admin\middleware\AdminUser::class);
});

// 验证码路由
Route::get('captcha/[:config]','\\think\\captcha\\CaptchaController@index')->name('captcha');