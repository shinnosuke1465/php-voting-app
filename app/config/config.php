<?php
declare(strict_types=1);

define('CURRENT_URI', $_SERVER['REQUEST_URI']);

// 現在のページのurlを取得
// index.phpファイルを読み込んだとき(localhost)このconfig.phpがよばれるため、そのときのREQUEST_URIはlocalhostを含まない/となる
// これでホスト名（例 : localhost）を含まないURL部分（例 : /）が取得可能
// BASE_CONTEXT_PATH = /
define('BASE_CONTEXT_PATH', "/");

// BASE_IMAGE_PATH = /images/
define('BASE_IMAGE_PATH', BASE_CONTEXT_PATH . 'images/');
define('BASE_JS_PATH', BASE_CONTEXT_PATH. 'js/');
define('BASE_CSS_PATH', BASE_CONTEXT_PATH . 'css/');
define('SOURCE_BASE', dirname(__DIR__) . '/htdocs/php/');

//リダイレクト処理
define('GO_HOME', 'home');
define('GO_REFERER', 'referer');
?>

