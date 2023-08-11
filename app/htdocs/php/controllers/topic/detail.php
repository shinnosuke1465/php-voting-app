<?php 
namespace controller\topic\detail;

use db\CommentQuery;
use lib\Msg;
use db\TopicQuery;
use model\TopicModel;

// 記事の詳細ページ（記事に対するコメントなどを表示）
function get() {

  // DBから取得した記事情報が入っている
    $topic = new TopicModel;
      // $topicのidにGET(url)で渡ってきたtopic_idの値（/topic/detail?topic_id=3の3）を格納
    $topic->id = get_param('topic_id', null, false);

    //上記のコードでgetで渡ってきた一つの記事だけの情報をDBから取得
    $fetchedTopic = TopicQuery::fetchById($topic);
    // commentテーブルの全てのコメントを取得。のちにループ文で回して表示する
    $comments = CommentQuery::fetchByTopicId($topic);

    //トピックの値が取れてこなかった時の処理
    if(!$fetchedTopic) {
        Msg::push(Msg::ERROR, 'トピックが見つかりません。');
        redirect('404');
    }

    //トピックが取れてきた時その取れてきた一つの記事情報と全てのコメント情報（連想配列）を渡す
    \view\topic\detail\index($fetchedTopic, $comments);
   
}