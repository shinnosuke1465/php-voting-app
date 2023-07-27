<?php

//controllers>login.phpファイル
// function post(){
//     $id = $_POST['id'] ?? '';
// }
// 上記のlogin.phpのpwdとid入力欄から記述された値を変数に宣言するコードを関数として定義し直したもの
function get_param($key, $default_val, $is_post = true)
{

  $arry = $is_post ? $_POST : $_GET;
  return $arry[$key] ?? $default_val;
}

// ログイン認証成功するとtopページへ遷移する
// header('Location: /');
// die();
//(controllers>login.php)上記のコードを関数で定義したもの
function redirect($path)
{

  //redirect関数が呼び出されて（login.phpで呼び出されている）その引数がGO_HOMEだったときから文字（topページへのurl）を返す
  if ($path === GO_HOME) {
    $path = get_url('');
  } else if ($path === GO_REFERER) {
  //ひとつ前のリクエスト(loginフォームのurl)を返す
    $path = $_SERVER['HTTP_REFERER'];
  } else {
    $path = get_url($path);
  }
  header("Location: {$path}");
  die();
}

function get_url($path)
{
  return BASE_CONTEXT_PATH . trim($path, '/');
}

function is_alnum($val) {
  return preg_match("/^[a-zA-Z0-9]+$/", $val);
}