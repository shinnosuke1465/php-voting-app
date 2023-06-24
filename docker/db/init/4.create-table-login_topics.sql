USE app_db;
-- 投稿内容を保存するテーブルの定義
CREATE TABLE `topics` (
`id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY COMMENT 'トピックID',
  `title` varchar(30) NOT NULL COMMENT 'トピック本文',
  `published` int(1) NOT NULL COMMENT '公開状態(1: 公開、0: 非公開)',
  `views` int(10) NOT NULL DEFAULT '0' COMMENT 'PV数',
  `likes` int(10) NOT NULL DEFAULT '0' COMMENT '賛成数',
  `dislikes` int(10) NOT NULL DEFAULT '0' COMMENT '反対数',
  `user_id` varchar(10) NOT NULL COMMENT '作成したユーザーID',
  `del_flg` int(1) NOT NULL DEFAULT '0' COMMENT '削除フラグ(1: 削除、0: 有効)',
  `updated_by` varchar(20) NOT NULL DEFAULT 'pollapp' COMMENT '最終更新者',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '最終更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_bin;