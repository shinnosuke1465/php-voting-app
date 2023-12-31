<?php
namespace controller\home;

use db\TopicQuery;

// 名前空間を使って関数を定義（グローバル空間（全てのファイル）の中で名前の重複を防ぐ）
//名前空間の呼び出し方
// $fn = \\controller\\home\\get;  バックスラッシュはエスケープしないといけない
// $fn();
function get(){

  $topics = TopicQuery::fetchPublishedTopics();
  \view\home\index($topics);
}
?>