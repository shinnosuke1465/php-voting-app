<?php

namespace controller\topic\edit;

use Throwable;
use db\DataSource;
use db\TopicQuery;
use db\CommentQuery;
use lib\Msg;
use lib\Auth;
use model\CommentModel;
use model\TopicModel;
use model\UserModel;

function get()
{
  //ログインしていない状態で/topic/archive.phpとurlを叩くとloginページにリダイレクトされる
  Auth::requireLogin();

    //編集がバリデーションによって失敗した時入力していた値をそのままにする処理(post()の登録失敗した時にsessionに保存した情報を取得してsession上のデータを削除)
    $topic = TopicModel::getSessionAndFlush();

    // 上記のコードが実装された時そのままindexを表示
    if(!empty($topic)) {
      \view\topic\edit\index($topic, true);
      // このコード以下の処理は必要ないためここでストップさせる
      return;
  }

  // url(/topic/edit?topic_id=4)で飛んできたtopicのidを格納するモデルを定義
  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null, false);

  //下記のコードでsessionに格納されたidを使いたいため取得
  $user = UserModel::getSession();

  // $userに定義されたid（sessionに保存されたuser_id）に紐ずく$topic->id(urlで飛んできたid)であれば編集できる機能
  Auth::requirePermission($topic->id, $user);

  //記事詳細ページでその記事のidに紐づくtopicsテーブル情報（記事は一つだけ取得することになる）とtopicsのidに結合させたuserテーブルのnicknameを取得する
  $fetchedTopic = TopicQuery::fetchById($topic);

  \view\topic\edit\index($fetchedTopic, true);
}

function post()
{

  Auth::requireLogin();

  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null);
  $topic->title = get_param('title', null);
  $topic->published = get_param('published', null);

  $user = UserModel::getSession();
  Auth::requirePermission($topic->id, $user);

  try {

    $is_success = TopicQuery::update($topic);
  } catch (Throwable $e) {

    Msg::push(Msg::DEBUG, $e->getMessage());
    $is_success = false;
  }

  if($is_success) {

    Msg::push(Msg::INFO, 'トピックの更新に成功しました。');
    redirect('topic/archive');

} else {

    Msg::push(Msg::ERROR, 'トピックの更新に失敗しました。');
       // formで飛んできた情報をsessionに保存
    TopicModel::setSession($topic);
        // 上記のget()が呼ばれる
    redirect(GO_REFERER);

}
}
