<?php
namespace controller\login;

use lib\Auth;

function get(){
  require_once(dirname(__DIR__) . "/views/login.php");
}

function post() {
  //libs>helper.phpで定義されている関数
  // login.phpのidとpassword入力欄で渡された値を受け取って変数に宣言
  //値が入力されていなかった時デフォルトで空文字を宣言
  $id = get_param('id', '');
  $pwd = get_param('pwd', '');

  if(Auth::login($id, $pwd)) {
      echo "認証成功";
      redirect(GO_HOME);
      //libs>helper.phpで定義されている関数
      // 認証成功するとtopページへ遷移する
      // header('Location: /');
      // die();
  } else {
    echo "認証失敗";
      // redirect(GO_REFERER);
      redirect(GO_REFERER);
  }
}