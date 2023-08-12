<?php

namespace controller\topic\create;

use Throwable;
use db\TopicQuery;
use lib\Msg;
use lib\Auth;
use model\TopicModel;
use model\UserModel;

function get()
{
  //ログインしていない状態で/topic/archive.phpとurlを叩くとloginページにリダイレクトされる
  Auth::requireLogin();

  //投稿がバリデーションによって失敗した時入力していた値をそのままにする処理(post()の登録失敗した時にsessionに保存した情報を取得してsession上のデータを削除)
  $topic = TopicModel::getSessionAndFlush();

  // 上記のコードでsessionから値が取れてこなかった時topicモデルを初期化
  if(empty($topic)){
    $topic = new TopicModel;
    $topic->id = -1;
    $topic->title = '';
    $topic->published = 1;
  }

  //そのまま編集画面を利用する。第二引数は編集画面の場合はtrue,投稿作成画面の時はfalse
  \view\topic\edit\index($topic, false);
}

function post()
{

  Auth::requireLogin();

  $topic = new TopicModel;
  $topic->id = get_param('topic_id', null);
  $topic->title = get_param('title', null);
  $topic->published = get_param('published', null);

  $user = UserModel::getSession();


  try {

    //DBにformで入力された投稿内容を挿入するメソッド(user情報も必要になるためsessionから取得する)
    $user = UserModel::getSession();
    $is_success = TopicQuery::insert($topic, $user);
  } catch (Throwable $e) {

    Msg::push(Msg::DEBUG, $e->getMessage());
    $is_success = false;
  }

  if($is_success) {

    Msg::push(Msg::INFO, 'トピックの登録に成功しました。');
    redirect('topic/archive');

} else {

    Msg::push(Msg::ERROR, 'トピックの登録に失敗しました。');
    // formで飛んできた情報をsessionに保存
    TopicModel::setSession($topic);
    // 上記のget()が呼ばれる
    redirect(GO_REFERER);

}
}
