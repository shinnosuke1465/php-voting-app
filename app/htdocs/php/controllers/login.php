<?php
namespace controller\login;

use lib\Auth;

function get(){
  require_once(dirname(__DIR__) . "/views/login.php");
}

function post() {
  // login.phpのidとpassword入力欄で渡された値を受け取って変数に宣言
  //値が入力されていなかった時デフォルトで空文字を宣言
  $id = get_param('id', '');
  $pwd = get_param('pwd', '');

  if(Auth::login($id, $pwd)) {

      // $user = UserModel::getSession();
      // Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ。");
      // redirect(GO_HOME);
      echo "認証成功";

  } else {

    echo "認証失敗";
      // redirect(GO_REFERER);

  }
}