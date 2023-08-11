<?php 
namespace model;

use lib\Msg;

//db/comment.query.phpでコメントテーブルから取得した情報を格納するための雛形
class CommentModel extends AbstractModel {

    public int $id;
    public int $topic_id;
    public int $agree;
    public string $body;
    public string $user_id;
    public string $nickname;
    public int $del_flg;

    protected static $SESSION_NAME = '_comment';
}

