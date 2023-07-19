<?php

namespace db;

use db\DataSource;
use model\UserModel;

// DB(votingapp)にから値を取ってくるためのsql文を作成してDataSourceに作成したsql文を渡すクラス
class UserQuery
{
    public static function fetchById($id)
    {

        $db = new DataSource;
        $sql = 'select * from users where id = :id;';

        $result = $db->selectOne($sql, [
            ':id' => $id
        ], DataSource::CLS, UserModel::class);

        return $result;
    }
    // ユーザー登録機能。$userはuser情報が格納されたオブジェクト（models>user.modelクラスのインスタンス）
    public static function insert($user)
    {

        $db = new DataSource;
        $sql = 'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname)';

        //パスワードのハッシュ化。第一引数...ハッシュ化したい文字。第二引数...どのようなアルゴリズム（ハッシュ関数）を使うか
        $user->pwd = password_hash($user->pwd, PASSWORD_DEFAULT);

        //executeは処理が成功するとtrueを返す
        return $db->execute($sql, [
            ':id' => $user->id,
            ':pwd' => $user->pwd,
            ':nickname' => $user->nickname,
        ]);
    }
}
