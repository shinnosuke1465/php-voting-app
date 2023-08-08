<?php 
namespace model;

use lib\Msg;

// register.phpで入力されたuserの情報を保持するクラス。
//userの情報をインスタンスオブジェクト（$user = new UserModel)としてまとめることでユーザ登録メソッド(controllers>register.php Auth::regist($user))などにオブジェクトを渡すだけでいいのでコードがスッキリする
class UserModel extends AbstractModel{

    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    //（libs>auth.phpのsessionにユーザ情報を定義するコード）$_SESSION['user'] = $user;をクラスとして定義する
    //_の意味..メソッドを通じて値を取得してください（setsession（）をつかって値を取得）
    protected static $SESSION_NAME = '_user';

    
    // ユーザー登録画面で入力されたidのチェック関数
    public static function validateId($val){
        //チェックが成功ならtrue失敗false
        $res = true;
        
        //$valが空文字だった場合下記のメッセージが表示
        if(empty($val)) {
            Msg::push(Msg::ERROR, 'ユーザーIDを入力してください。');
            $res = false;
        }else {
            if(strlen($val) > 10){
                Msg::push(Msg::ERROR, 'ユーザーIDは10 桁以下で入力してください');
                $res = false;
            }
            //値（ID）が半角英数字かチェック
            if(!is_alnum($val)) {
                Msg::push(Msg::ERROR, 'ユーザーIDは半角英数字で入力してください');
                $res = false;
            }
        }
        return $res;
    }

    //auth.phpで呼び出している
    public function isValidId() {
        return static::validateId($this->id);
    }

    // ユーザー登録画面で入力されたpwdのチェック関数
    public static function validatePwd($val)
    {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'パスワードを入力してください。');
            $res = false;

        } else {

            if(strlen($val) < 4) {

                Msg::push(Msg::ERROR, 'パスワードは４桁以上で入力してください。');
                $res = false;

            }

            if(!is_alnum($val)) {

                Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください。');
                $res = false;

            }
        }

        return $res;
    }

    public function isValidPwd()
    {
        return static::validatePwd($this->pwd);
    }

// ユーザー登録画面で入力されたニックネームのチェック関数
    public static function validateNickname($val)
    {

        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'ニックネームを入力してください。');
            $res = false;

        } else {

            if(mb_strlen($val) > 10) {

                Msg::push(Msg::ERROR, 'ニックネームは１０桁以下で入力してください。');
                $res = false;

            }
        }

        return $res;
    }

    public function isValidNickname()
    {
        return static::validateNickname($this->nickname);
    }
}

