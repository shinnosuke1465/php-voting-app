USE app_db;

-- 投稿された内容にコメントを管理するcommentsテーブルを定義。
CREATE TABLE `comments` (
  `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'コメントID',
  `topic_id` int(10) NOT NULL COMMENT 'トピックID',
  `agree` int(1) NOT NULL COMMENT '賛否（賛成: 1, 反対: 0）',
  `body` varchar(100) DEFAULT NULL COMMENT '本文',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'pollapp' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
);