<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

// ThinkPHP 引导文件
// 加载基础文件
session_start();
require __DIR__ . '/base.php';
require CORE_PATH . 'Loader.php';

// 注册自动加载
Loader::register();

// 加载模式定义文件
$mode = require MODE_PATH . APP_MODE . EXT;

// 加载模式命名空间定义
if (isset($mode['namespace'])) {
    Loader::addNamespace($mode['namespace']);
}

// 加载模式别名定义
if (isset($mode['alias'])) {
    Loader::addMap($mode['alias']);
}

// 注册错误和异常处理机制
Error::register();

// 加载模式配置文件
if (isset($mode['config'])) {
    is_array($mode['config']) ? Config::set($mode['config']) : Config::load($mode['config']);
}

// 加载模式行为定义
if (APP_HOOK && isset($mode['tags'])) {
    Hook::import($mode['tags']);
}
//add by sven 2016.3.28
if(!IS_CLI) {
    // 当前文件名
    if(!defined('_PHP_FILE_')) {
        if(IS_CGI) {
            //CGI/FASTCGI模式下
            $_temp  = explode('.php',$_SERVER['PHP_SELF']);
            define('_PHP_FILE_',    rtrim(str_replace($_SERVER['HTTP_HOST'],'',$_temp[0].'.php'),'/'));
        }else {
            define('_PHP_FILE_',    rtrim($_SERVER['SCRIPT_NAME'],'/'));
        }
    }
    if(!defined('__ROOT__')) {
        $_root  =   rtrim(dirname(_PHP_FILE_),'/');
        define('__ROOT__',  (($_root=='/' || $_root=='\\')?'':$_root));
        define('__STATIC__', __ROOT__.'/static');
    }
}

// 是否自动运行
if (APP_AUTO_RUN) {
    App::run();
}
