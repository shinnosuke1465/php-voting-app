<?php 
$uri = $_SERVER['REQUEST_URI'];

#i...大文字と小文字を区別しない。
#preg_match(条件,調べる対象の文字列,条件でマッチした文字列を格納する配列)
#'BASE_CONTEXT_PATH'の値はマッチした文字列（$match[0]）の後に'/'を付け加えたものとなります。
// if(preg_match("/(.+(start|end))/i", $uri, $match)) {
//     define('BASE_CONTEXT_PATH', $match[0] . '/');
// }
define('BASE_IMAGE_PATH', $uri . 'images/');
define('BASE_JS_PATH', $uri . 'js/');
define('BASE_CSS_PATH', $uri . 'css/');
define('SOURCE_BASE', __DIR__ . '/php/');