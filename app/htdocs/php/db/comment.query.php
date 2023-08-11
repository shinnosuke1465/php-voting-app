<?php

namespace db;

use db\DataSource;
use model\CommentModel;

  //commentテーブルとuserテーブルのnicknameを結合した情報を取得するしてmodels/comment.model.phpの雛形に格納する
class CommentQuery
{

  public static function fetchByTopicId($topic)
  {

    if (!$topic->isValidId()) {
      return false;
    }

    $db = new DataSource;
    // and c.body != ""
    // 空でないレコードを取得
    
    $sql = '
        select
            c.*, u.nickname
        from comments c
        inner join users u
            on c.user_id = u.id
        where c.topic_id = :id
            and c.body != ""
            and c.del_flg != 1
            and u.del_flg != 1
        order by c.id desc
        ';

    $result = $db->select($sql, [
      ':id' => $topic->id
    ], DataSource::CLS, CommentModel::class);

    return $result;
  }

}
