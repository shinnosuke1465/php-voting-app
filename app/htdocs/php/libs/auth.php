<?php

namespace lib;

use db\UserQuery;
use model\UserModel;
use Throwable;

// use model\UserModel;
// use Throwable;

//認証機能クラス
class Auth
{
  public static function login($id, $pwd)
  {
    try {
      if(!(UserModel::validateId($id)
          * UserModel::validatePwd($pwd))){
          return false;
      }
      $is_success = false;

      $user = UserQuery::fetchById($id);

      if (!empty($user) && $user->del_flg !== 1) {

        if (password_verify($pwd, $user->pwd)) {
          $is_success = true;
          // //値が格納されているかされていないかでログインしているかがわかる
          // $_SESSION['user'] = $user;
          UserModel::setSession($user);
        } else {
          echo 'パスワードが一致しません';
        }
      } else {
        echo 'userが見つかりません';
      }
    } catch (Throwable $e) {

      $is_success = false;
      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'ログイン処理でエラーが発生しました');
    }


    return $is_success;
  }

  // ユーザー登録機能
  public static function regist($user)
  {
    try {
      //$user->isValidId()...(UserModelクラス)登録ページで入力されたpwdとidのチェック関数でfalseが帰ってきた場合if文の中身が実行される
      if(!($user->isValidId()
          * $user->isValidPwd()
          * $user->isValidNickname())){
          return false;
      }

      //処理が成功したかのフラグ。成功したらreturnでtrueにして返す
      $is_success = false;

      $exist_user = UserQuery::fetchById($user->id);

      if (!empty($exist_user)) {
        echo "ユーザーが既に存在します";
        return false;
      }
      //ユーザーidが登録されていなかったらinsertメソッドでDBにidとpwdとnicknameを登録して成功したらtureを返す
      $is_success = UserQuery::insert($user);

      //ユーザが上記のコードで登録されたらセッションにuser情報を定義してログインしている状態にする
      if ($is_success) {
        //$_SESSION['user'] = $user;
        UserModel::setSession($user);
      }
    } catch (Throwable $e) {

      $is_success = false;
      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'ユーザー登録でエラーが発生しました');

    }

    return $is_success;
  }


  //ログインしているか確認するメソッド
  public static function isLogin(){
    try {
      $user = UserModel::getSession();
    } catch (Throwable $e) {
      UserModel::clearSession();
      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'エラーが発生しました。再度ログインを行ってください');
      return false;
    }
    // SESSIONにuser情報が格納されていたらtrueを返しログインしていることにする
    if (isset($user)) {
      return true;
    } else {
      return false;
    }
  }

  // public static function isLogin()
  // {
  //     try {

  //         $user = UserModel::getSession();
  //     } catch (Throwable $e) {

  //         UserModel::clearSession();
  //         Msg::push(Msg::DEBUG, $e->getMessage());
  //         return false;
  //     }

  //     if (isset($user)) {
  //         return true;
  //     } else {
  //         return false;
  //     }

  // }

  // public static function logout() {
  //     try {

  //         UserModel::clearSession();

  //     } catch (Throwable $e) {

  //         Msg::push(Msg::DEBUG, $e->getMessage());
  //         return false;

  //     }

  //     return true;
  // }
}
