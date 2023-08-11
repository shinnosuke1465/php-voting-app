<?php
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
require_once(SOURCE_BASE . 'models/topic.model.php');
require_once(SOURCE_BASE . 'models/comment.model.php');

//Message
require_once(SOURCE_BASE . 'libs/message.php');

//  DB
require_once(SOURCE_BASE . 'db/datasource.php');
require_once(SOURCE_BASE . 'db/user.query.php');
require_once(SOURCE_BASE . 'db/topic.query.php');
require_once(SOURCE_BASE . 'db/comment.query.php');

//Partials
require_once(SOURCE_BASE . 'partials/topic-list-item.php');
require_once(SOURCE_BASE . 'partials/topic-header-item.php');
require_once(SOURCE_BASE . 'partials/header.php');
require_once(SOURCE_BASE . 'partials/footer.php');

//View
require_once(SOURCE_BASE . "views/home.php");
require_once(SOURCE_BASE . "views/login.php");
require_once(SOURCE_BASE . "views/register.php");
require_once(SOURCE_BASE . "views/topic/archive.php");
require_once(SOURCE_BASE . "views/topic/detail.php");
require_once(SOURCE_BASE . "views/topic/edit.php");



use function lib\route;

session_start();

//urlを叩いた時の処理
try{

    \Partials\header();

    //http://localhost/topic/detail?topic_id=3とurlを叩いた場合
    //path: http://localhost/topic/detail
    //query:?topic_id=3と別れる
    $url = parse_url(CURRENT_URI);
// localhost/loginとurlを叩いたとき$rpathにloginが格納される
// $_SERVER['REQUEST_URI'](/login)からBASE_CONTEXT_PATH(/)にマッチした/をから文字に変換（除去）する
// $rpath = str_replace(BASE_CONTEXT_PATH, '', $_SERVER['REQUEST_URI']);
//ほんとは上記のコードだがlocalhost/topic/archiveとurlが叩かれた時に$rpathに格納される値がtopicarchiveとなってしまうため以下のようにコードを修正

if (strpos($url['path'], BASE_CONTEXT_PATH) === 0) {
    $rpath = substr($url['path'], strlen(BASE_CONTEXT_PATH));
}

// 小文字でREQUEST_METHOD（postかget）を取得できる
$method = strtolower($_SERVER['REQUEST_METHOD']);

// 下記のroute関数を呼び出す
route($rpath, $method);

\Partials\footer();
} catch(Throwable $e) {
    echo '<h1>何かがすごくおかしいようです</h1>';
    echo '<p>エラーメッセージ: ' . $e->getMessage() . '</p>';
    echo '<p>エラーが発生したファイル: ' . $e->getFile() . '</p>';
    echo '<p>エラーが発生した行: ' . $e->getLine() . '</p>';
    die();
}




