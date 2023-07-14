<?php

// dirname(__DIR__)...今いるディレクトリの親のディレクトリを返す（appディレクトリ）
require_once( dirname(__DIR__) .'/config/config.php');

// Model
require_once(SOURCE_BASE . 'models/user.model.php');

// . DB
require_once(SOURCE_BASE . 'db/datasource.php');
require_once(SOURCE_BASE . 'db/user.query.php');

use DB\UserQuery;
$result = UserQuery::fetchById('test');
var_dump($result);

require_once(SOURCE_BASE . 'partials/header.php');

// localhost/loginとurlを叩いたとき$rpathにloginが格納される
// $_SERVER['REQUEST_URI']からBASE_CONTEXT_PATHにマッチした/をから文字に変換（除去）する
$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);

// 小文字でREQUEST_METHOD（postかget）を取得できる
$method = strtolower($_SERVER['REQUEST_METHOD']);

// 下記のroute関数を呼び出す
route($rpath, $method);

function route($rpath, $method) {
    if($rpath === '') {
        $rpath = 'home';
    }

// localhost/loginとurlを叩いたとき($targetFile = app/htdocs/php/controllers/login.php
    $targetFile = SOURCE_BASE . "controllers/{$rpath}.php";

// ファイルが存在しなかったとき404ページを表示
    if(!file_exists($targetFile)) {
        require_once SOURCE_BASE . "views/404.php";
        return;
    }

//ファイルが存在した時はそのままphpファイルを表示する
    require_once $targetFile;

    $fn = "\\controller\\{$rpath}\\{$method}";

    $fn();
}

// if($_SERVER['REQUEST_URI'] === '/login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif($_SERVER['REQUEST_URI'] === '/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif($_SERVER['REQUEST_URI'] === '/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }

require_once(SOURCE_BASE . 'partials/footer.php');


