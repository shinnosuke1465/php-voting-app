<?php

namespace model;

use Error;

//（libs>auth.phpのsessionにユーザ情報を定義するコード）$_SESSION['user'] = $user;をクラスのメソッドとして定義する
//abstract...継承しないと使えないクラス
abstract class AbstractModel {
  protected static $SESSION_NAME = null;

  public static function setSession($val) {

    if (empty(static::$SESSION_NAME)) {
      throw new Error('$SESSIOM_NAMEを設定してください');
    }
    //static::$_SESSION_NAMEのstaticは継承先のクラス（UserModel）を参照する
    $_SESSION[static::$SESSION_NAME] = $val;
  }

  public static function getSession() {
    return $_SESSION[static::$SESSION_NAME] ?? null;
  }

  // sessionに格納された値を初期化できる
  public static function clearSession() {

    static::setSession(null);
  }
}
