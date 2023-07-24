<?php

namespace model;

use Error;

//（libs>auth.phpのsessionにユーザ情報を定義するコード）$_SESSION['user'] = $user;をクラスのメソッドとして定義する
//abstract...継承しないと使えないクラス
abstract class AbstractModel {
// クラスを使う場合継承先のクラスでSESSION_NAMEを定義する必要がある。SESSION＿NAMEを指定することでsetSessionやgetSessionを使える
  protected static $SESSION_NAME = null;

  public static function setSession($val) {

    if (empty(static::$SESSION_NAME)) {
      throw new Error('$SESSIOM_NAMEを設定してください');
    }
    //static::$_SESSION_NAMEのstaticは継承先のクラス（UserModel）を参照する
    //userModelクラスでprotected static $SESSION_NAME ＝ '_user'と定義されているため下記のコードは$_SESSION[_user]となる
    $_SESSION[static::$SESSION_NAME] = $val;
    // 上記のコードの$valは 
    //$user = new UserModel;
    // $user->id = get_param('id', '');
    // $user->pwd = get_param('pwd', '');
    // $user->nickname = get_param('nickname', '');で格納されたuser情報
    //下記のようにsessionに格納される
    //$_SESSION[_user] = array(
//     'user1' => array(
//       'id' => $user1->id,
//       'pwd' => $user1->pwd,
//       'nickname' => $user1->nickname,
//       'del_flg' => 0
//   ),
//   'user2' => array(
//       'id' => $user2->id,
//       'pwd' => $user2->pwd,
//       'nickname' => $user2->nickname,
//       'del_flg' => 0
//   ),
//   'user3' => array(
//       'id' => $user3->id,
//       'pwd' => $user3->pwd,
//       'nickname' => $user3->nickname,
//       'del_flg' => 0
//   )
// );
  }

  public static function getSession() {
    return $_SESSION[static::$SESSION_NAME] ?? null;
  }

  // sessionに格納された値を初期化できる
  public static function clearSession() {

    static::setSession(null);
  }

  // SESSIONが取れてその後取れてきたSESSION上の値は削除される＝画面にメッセージが残り続けない
  public static function getSessionAndFlush() {
    try {
      return static::getSession();
    } finally {
      static::clearSession();
    }
  }
}
