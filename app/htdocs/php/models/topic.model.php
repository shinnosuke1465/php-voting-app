<?php
namespace model;

use lib\Msg;

//db/topic.query.phpでtopicテーブルとuserテーブルのニックネームを結合して取得した情報を格納するための雛形
class TopicModel extends AbstractModel
{

    public int $id;
    public string $title;
    public int $published;
    public int $views;
    public int $likes;
    public int $dislikes;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    //（libs>auth.phpのsessionにユーザ情報を定義するコード）$_SESSION['user'] = $user;をクラスとして定義する
    //_の意味..メソッドを通じて値を取得してください（setsession（）をつかって値を取得）
    protected static $SESSION_NAME = '_topic';
    public function isValidId() {

        return true;

    }

    public static function validateId($val) {
        return true;
    }
}
