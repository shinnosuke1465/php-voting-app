<?php

// dirname(__DIR__)...今いるディレクトリの親のディレクトリを返す（appディレクトリ）
require_once( dirname(__DIR__) .'/config/config.php');


require_once( dirname(__DIR__) .'/htdocs/php/partials/header.php');
$request_uri = $_SERVER['REQUEST_URI'];
echo $_SERVER['REQUEST_URI'];
// 対象の文字列(第３引数)と第一引数の文字列とマッチした文字を第二引数で置換する
// 例 localhost/loginとアクセスした場合。$_SERVER['REQUEST_URI']=/login $uri=/のためマッチする/が空文字に変換され$rpath＝loginとなる
if($_SERVER['REQUEST_URI'] === "/login") {
    require_once(dirname(__DIR__).'/htdocs/php/controllers/login.php');
} elseif (mb_strpos($_SERVER['REQUEST_URI'] , "/register") !== false){
    require_once(dirname(__DIR__) . '/htdocs/php/controllers/register.php');
} elseif (mb_strpos($_SERVER['REQUEST_URI'] , "/") !== false) {
    require_once(dirname(__DIR__) . '/htdocs/php/controllers/home.php');
}

require_once( dirname(__DIR__) .'/htdocs/php/partials/footer.php');
?>