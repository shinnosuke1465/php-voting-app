<?php

namespace lib;

use db\TopicQuery;
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
          Msg::push(Msg::ERROR, 'パスワードが一致しません');
        }
      } else {
        Msg::push(Msg::ERROR, 'ユーザーが見つかりません');
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
        Msg::push(Msg::ERROR, 'ユーザーが既に存在します');
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

  public static function logout() {
      try {

          UserModel::clearSession();

      } catch (Throwable $e) {

          Msg::push(Msg::DEBUG, $e->getMessage());
          return false;

      }

      return true;
  }
  //ログインしていなかったらloginページにリダイレクト。
  public static function requireLogin(){
    if(!static::isLogin()){
      Msg::push(Msg::ERROR,'ログインしてください');
      redirect('login');
    }
  }

  //記事編集権限があるか（  // $userに定義されたidに紐ずく$topic->idであれば編集できる機能）判定
  public static function hasPermission($topic_id, $user){
    return TopicQuery::isUserOwnTopic($topic_id, $user);
  }

  public static function requirePermission($topic_id, $user){

    // 記事編集権限判定関数の結果がfalseだった時以下のエラーメッセージ表示
    if(!static::hasPermission($topic_id,$user)){
      Msg::push(Msg::ERROR,'編集権限がありません。ログインして再度試してみてください');
      redirect('login');
    }
  }
}
