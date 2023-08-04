<?php
namespace controller\login;

use lib\Auth;
use lib\Msg;
use model\UserModel;

function get(){
  \view\login\index();
}

function post() {
  //libs>helper.phpで定義されている関数
  // login.phpのidとpassword入力欄で渡された値を受け取って変数に宣言
  //値が入力されていなかった時デフォルトで空文字を宣言
  $id = get_param('id', '');
  $pwd = get_param('pwd', '');

  if(Auth::login($id, $pwd)) {

    $user = UserModel::getSession();
      Msg::push(Msg::INFO,"{$user->nickname}さん、ようこそ");
      redirect(GO_HOME);
      //libs>helper.phpで定義されている関数
      // 認証成功するとtopページへ遷移する
      // header('Location: /');
      // die();
  } else {
      redirect(GO_REFERER);
  }
}