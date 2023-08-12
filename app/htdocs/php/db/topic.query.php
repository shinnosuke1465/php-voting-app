<?php

namespace db;

use db\DataSource;
use model\TopicModel;
use model\UserModel;

// DB(votingapp)にから値を取ってくるためのsql文を作成してDataSourceに作成したsql文を渡すクラス（DBからsql文を使って指定したテーブルの行をとってくるクラス）
class TopicQuery
{
  //topicsテーブルからuser_idに紐づく行を取得すしてarchive.phpに渡す
  public static function fetchByUserId($user)
  {
    if (!$user->isValidId()) {
      return false;
    }
    $db = new DataSource;
    $sql = 'select * from topics where user_id = :id and del_flg != 1 order by id desc;';

    //new DataSourceでDBに接続。selectメソッドで値を取得。引数の意味（sql文,idをprepare構文で指定,DataSource::CLSでclassで値を取得することを指定。topicModel::classの雛形に取得した値を打ち込む）
    $result = $db->select($sql, [
      ':id' => $user->id
    ], DataSource::CLS, TopicModel::class);

    return $result;
  }

  //topicsテーブル情報とtopicsのidに結合させたuserテーブルのnicknameを取得する
  /*
テーブルの内部結合（INNER JOIN）
 select * from テーブル１
 inner join テーブル２
 on テーブル１.値が一致する属性 = テーブル２.値が一致する属性;
*/
// .   topicsテーブルのuser_id(test)とuserテーブルのid(test)が一致するuserテーブルのnicknameを表示
//      on t.user_id = u.id
//
// .     del_flgが1でないものを表示する
//        where t.del_flg != 1
//            and u.del_flg != 1
  public static function fetchPublishedTopics()
  {
    $db = new DataSource;
    $sql = '
        select
            t.*, u.nickname
        from topics t
        inner join users u
            on t.user_id = u.id
        where t.del_flg != 1
            and u.del_flg != 1
            and t.published = 1
        order by t.id desc
        ';

    $result = $db->select($sql, [], DataSource::CLS, TopicModel::class);

    return $result;
  }


    //詳細ページでその記事のidに紐づくtopicsテーブル情報（記事は一つだけ取得することになる）とtopicsのidに結合させたuserテーブルのnicknameを取得する
  public static function fetchById($topic) {

    if(!$topic->isValidId()) {
        return false;
    }

    $db = new DataSource;
    $sql = '
    select
        t.*, u.nickname
    from topics t
    inner join users u
        on t.user_id = u.id
    where t.id = :id
        and t.del_flg != 1
        and u.del_flg != 1
    order by t.id desc
    ';

    // 記事のidを引数で渡ってきたtopicのidにバインドして一つのレコードだけ取得
    $result = $db->selectOne($sql, [
        ':id' => $topic->id
    ], DataSource::CLS, TopicModel::class);

    return $result;

}

// 記事のviewを増やす機能
public static function incrementViewCount($topic){
  if(!$topic->isValidId()){
    return false;
  }
  $db = new DataSource;

  $sql = 'update topics set views = views + 1 where id = :id;';

  return $db->execute($sql,[
    ':id' => $topic->id
  ]);
}

//記事を編集する際、記事のidとそれに紐ずくuserのid(test)をwhereで条件指定してレコードが取れてきたら編集できるという意味
public static function isUserOwnTopic($topic_id, $user)
{

    if (!(TopicModel::validateId($topic_id) && $user->isValidId())) {
        return false;
    }

    $db = new DataSource;
    $sql = '
    select count(1) as count from votingapp.topics t
    where t.id = :topic_id
        and t.user_id = :user_id
        and t.del_flg != 1;
    ';

    $result = $db->selectOne($sql, [
        ':topic_id' => $topic_id,
        ':user_id' => $user->id,
    ]);

    //dbから取得したカウントが空ではなく0でもなかった場合trueを返す
    return !empty($result) && $result['count'] != 0;
}

// 記事の編集（edit.php）で呼び出されformで入力された変更内容をDBに更新するメソッド
public static function update($topic)
{

  //値のチェック
  if (!($topic->isValidId()
  * $topic->isValidTitle()
  * $topic->isValidPublished())) {
  return false;
}

    $db = new DataSource;
    $sql = 'update topics set published = :published, title = :title where id = :id';

    //execute＝dbに登録するメソッド
    return $db->execute($sql, [
        ':published' => $topic->published,
        ':title' => $topic->title,
        ':id' => $topic->id,
    ]);
}

// 投稿作成画面（create.php）で呼び出されformで入力された変更内容をDBに更新するメソッド
public static function insert($topic, $user)
{
    //値のチェック
    if (!($user->isValidId()
        * $topic->isValidTitle()
        * $topic->isValidPublished())) {
        return false;
    }

    $db = new DataSource;
    //idはオートインクリメントで自動的に割り当てられるため指定しなくていい
    $sql = 'insert into topics(title, published, user_id) values (:title, :published, :user_id)';

    return $db->execute($sql, [
        ':title' => $topic->title,
        ':published' => $topic->published,
        ':user_id' => $user->id,
    ]);
}

//topicテーブルのlikesかdislikesに+1をする機能
public static function incrementLikesOrDislikes($comment){
  if (!($comment->isValidTopicId()
  * $comment->isValidAgree())) {
  return false;
}

$db = new DataSource;

//agreeが1だった場合likesを+1
//0だった場合dislikesを+1
if($comment->agree) {

  $sql = 'update topics set likes = likes + 1 where id = :topic_id';

} else {

  $sql = 'update topics set dislikes = dislikes + 1 where id = :topic_id';

}

return $db->execute($sql, [
  ':topic_id' => $comment->topic_id
]);
}

}
