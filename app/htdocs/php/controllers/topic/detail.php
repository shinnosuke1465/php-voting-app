<?php

namespace controller\topic\detail;

use db\DataSource;
use db\CommentQuery;
use db\TopicQuery;
use lib\Msg;
use lib\Auth;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;
use Throwable;

// 記事の詳細ページ（記事に対するコメントなどを表示）
function get()
{

  // DBから取得した記事情報が入っている
  $topic = new TopicModel;
  // $topicのidにGET(url)で渡ってきたtopic_idの値（/topic/detail?topic_id=3の3）を格納
  $topic->id = get_param('topic_id', null, false);

  TopicQuery::incrementViewCount($topic);

  //上記のコードでgetで渡ってきた一つの記事だけの情報をDBから取得
  $fetchedTopic = TopicQuery::fetchById($topic);
  // commentテーブルの全てのコメントを取得。のちにループ文で回して表示する
  $comments = CommentQuery::fetchByTopicId($topic);

  //トピックの値が取れてこなかった時の処理
  if (empty($fetchedTopic) || !$fetchedTopic->published) {
    Msg::push(Msg::ERROR, 'トピックが見つかりません。');
    redirect('404');
  }

  //トピックが取れてきた時その取れてきた一つの記事情報と全てのコメント情報（連想配列）を渡す
  \view\topic\detail\index($fetchedTopic, $comments);
}

// コメント投稿機能
//topicテーブルのlikesかdislikesに+1をする機能
//commentテーブルにinsert
function post()
{
  Auth::requireLogin();

  // コメントformを入力して飛んできた値をcommentModelに格納
  $comment = new CommentModel;
  $comment->topic_id = get_param('topic_id', null);
  $comment->agree = get_param('agree', null);
  $comment->body = get_param('body', null);

  // ユーザー情報をセッションから取得してここで取れてきたuser_idをcommentのuser_idに格納
  $user = UserModel::getSession();
  $comment->user_id = $user->id;

  try {

    $db = new DataSource;

    //トランザクションの開始
    $db->begin();

    //topicテーブルのlikesかdislikesに+1をする機能
    //実行結果（true or false）を変数に格納
    $is_success = TopicQuery::incrementLikesOrDislikes($comment);

    //上記の機能がtrueの場合かつcommentの入力欄に値が格納されていたらcomment insert機能を実装
    if ($is_success && !empty($comment->body)) {
      //commentテーブルにinsert
      //$is_successがtrueの場合コメントの登録に成功しましたと表示する
      $is_success = CommentQuery::insert($comment);
    }
  } catch (Throwable $e) {

    Msg::push(Msg::DEBUG, $e->getMessage());
    $is_success = false;
  } finally {
    //必ず実行されるブロック
    if ($is_success) {

      $db->commit();
      Msg::push(Msg::INFO, 'コメントの登録に成功しました。');
    } else {

      $db->rollback();
      Msg::push(Msg::ERROR, 'コメントの登録に失敗しました。');
    }
  }

  redirect('topic/detail?topic_id=' . $comment->topic_id);
}

