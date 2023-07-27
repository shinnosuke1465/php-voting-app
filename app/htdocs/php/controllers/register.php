<?php
namespace controller\register;

use lib\Auth;
use model\UserModel;

function get(){
  require_once(dirname(__DIR__) . "/views/register.php");
}
function post() {
  // login.phpのidとpassword入力欄で渡された値を受け取って変数に宣言
  //値が入力されていなかった時デフォルトで空文字を宣言
  //UserModelクラス..値を保持してAuth::regist()の引数で渡しやすくするためのクラス
  $user = new UserModel;
  $user->id = get_param('id', '');
  $user->pwd = get_param('pwd', '');
  $user->nickname = get_param('nickname', '');

  //registメソッドの中でユーザーを登録し正常に登録できたらtrueを返す
  if(Auth::regist($user)) {
      // $user = UserModel::getSession(); auth.phpのログイン状態の確認クラスで記述
      // Msg::push(Msg::INFO, "{$user->nickname}さん、ようこそ。");
      redirect(GO_HOME);
      echo "登録成功";
  } else {
      echo "登録失敗";
      redirect(GO_REFERER);
  }
}