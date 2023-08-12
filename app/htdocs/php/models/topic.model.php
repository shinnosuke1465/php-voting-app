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
    public function isValidId()
    {
        return static::validateId($this->id);
    }

    //値がからではなく数値かどうか
    public static function validateId($val) {
        $res = true;

        //is_numeric...値が数値かどうか確認する関数
        if (empty($val) || !is_numeric($val)) {

            Msg::push(Msg::ERROR, 'パラメータが不正です。');
            $res = false;

        }

        return $res;
    }

    public function isValidTitle()
    {
        return static::validateTitle($this->title);
    }

    //文字数30文字以内
    //空ではないか
    public static function validateTitle($val) {
        $res = true;

        if (empty($val)) {

            Msg::push(Msg::ERROR, 'タイトルを入力してください。');
            $res = false;

        } else {

            if (mb_strlen($val) > 30) {

                Msg::push(Msg::ERROR, 'タイトルは30文字以内で入力してください。');
                $res = false;

            }

        }

        return $res;
    }

    public function isValidPublished()
    {
        return static::validatePublished($this->published);
    }

    //渡ってきたpublishe_idが1か０か確認
    public static function validatePublished($val) {
        $res = true;

        if (!isset($val)) {

            Msg::push(Msg::ERROR, '公開するか選択してください。');
            $res = false;

        } else {
            // 0、または1以外の時
            if (!($val == 0 || $val == 1)) {

                Msg::push(Msg::ERROR, '公開ステータスが不正です。');
                $res = false;

            }
        }

        return $res;
    }
}
