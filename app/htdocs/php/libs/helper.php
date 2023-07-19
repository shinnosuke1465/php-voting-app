<?php

//controllers>login.phpファイル
// function post(){
//     $id = $_POST['id'] ?? '';
// }
// 上記のlogin.phpのpwdとid入力欄から記述された値を変数に宣言するコードを関数として定義し直したもの
function get_param($key, $default_val, $is_post = true) {

    $arry = $is_post ? $_POST : $_GET;
    return $arry[$key] ?? $default_val;

}
?>