<?php
session_start();
ob_start();

// dirname(__DIR__)...今いるディレクトリの親のディレクトリを返す（appディレクトリ）
require_once( dirname(__DIR__) .'/config/config.php');

// Library
require_once(SOURCE_BASE . 'libs/helper.php');
require_once SOURCE_BASE . 'libs/auth.php';
require_once SOURCE_BASE . 'libs/router.php';


// Model
require_once(SOURCE_BASE . 'models/abstract.model.php');
require_once(SOURCE_BASE . 'models/user.model.php');

//Message
require_once(SOURCE_BASE . 'libs/message.php');

// . DB
require_once(SOURCE_BASE . 'db/datasource.php');
require_once(SOURCE_BASE . 'db/user.query.php');

use function lib\route;

try{
    require_once(SOURCE_BASE . 'partials/header.php');

// localhost/loginとurlを叩いたとき$rpathにloginが格納される
// $_SERVER['REQUEST_URI']からBASE_CONTEXT_PATHにマッチした/をから文字に変換（除去）する
$rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);

// 小文字でREQUEST_METHOD（postかget）を取得できる
$method = strtolower($_SERVER['REQUEST_METHOD']);

// 下記のroute関数を呼び出す
route($rpath, $method);

// if($_SERVER['REQUEST_URI'] === '/login') {
//     require_once SOURCE_BASE . 'controllers/login.php';
// } elseif($_SERVER['REQUEST_URI'] === '/register') {
//     require_once SOURCE_BASE . 'controllers/register.php';
// } elseif($_SERVER['REQUEST_URI'] === '/') {
//     require_once SOURCE_BASE . 'controllers/home.php';
// }

require_once(SOURCE_BASE . 'partials/footer.php');
} catch(Throwable $e) {
    die('<h1>何かがすごくおかしいようです</h1>');
}




