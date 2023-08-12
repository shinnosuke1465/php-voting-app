<?php

namespace lib;

use Throwable;

function route($rpath, $method)
{
  try {
    if ($rpath === '') {
      $rpath = 'home';
    }

    // localhost/loginとurlを叩いたとき($targetFile = app/htdocs/php/controllers/login.php
    $targetFile = SOURCE_BASE . "controllers/{$rpath}.php";

    // ファイルが存在しなかったとき404ページを表示
    if (!file_exists($targetFile)) {
      require_once SOURCE_BASE . "views/404.php";
      return;
    }

    //ファイルが存在した時はそのままphpファイルを表示する
    require_once $targetFile;

    $rpath = str_replace('/', '\\', $rpath);

    //引数で渡した$method(POSTかGET)がPOSTだった場合controllerのphpファイルのPOST()メソッドを実行する
    $fn = "\\controller\\{$rpath}\\{$method}";

    $fn();
  } catch (Throwable $e) {
    Msg::push(Msg::DEBUG, $e->getMessage());
    Msg::push(Msg::ERROR, '何かがおかしいようです');
    redirect('404');
    echo '<p>エラーメッセージ: ' . $e->getMessage() . '</p>';
    echo '<p>エラーが発生したファイル: ' . $e->getFile() . '</p>';
    echo '<p>エラーが発生した行: ' . $e->getLine() . '</p>';
  }
}
