<?php
namespace db;

use db\DataSource;
use model\TopicModel;
use model\UserModel;

// DB(votingapp)にから値を取ってくるためのsql文を作成してDataSourceに作成したsql文を渡すクラス（DBからsql文を使って指定したテーブルの行をとってくるクラス）
class TopicQuery
{
  //topicsテーブルからuser_idに紐づく行を取得する
    public static function fetchByUserId($user)
    {
        if(!$user->isValidId()){
          return false;
        }
        $db = new DataSource;
        $sql = 'select * from votingapp.topics where user_id = :id and del_flg != 1 order by id desc;';

        $result = $db->select($sql, [
            ':id' => $user->id
        ], DataSource::CLS, TopicModel::class);

        return $result;
    }
    // ユーザー登録機能。$userはuser情報が格納されたオブジェクト（models>user.modelクラスのインスタンス）
    // public static function insert($user)
    // {

    //     $db = new DataSource;
    //     $sql = 'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname)';

    //     //パスワードのハッシュ化。第一引数...ハッシュ化したい文字。第二引数...どのようなアルゴリズム（ハッシュ関数）を使うか
    //     $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

    //     //executeは処理が成功するとtrueを返す
    //     return $db->execute($sql, [
    //         ':id' => $user->id,
    //         ':pwd' => $user->pwd,
    //         ':nickname' => $user->nickname,
    //     ]);
    // }
}
