<?php 
namespace model;

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
}
