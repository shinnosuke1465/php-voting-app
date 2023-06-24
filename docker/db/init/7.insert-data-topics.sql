USE app_db;

START TRANSACTION;

SET time_zone = "+09:00";


INSERT INTO `topics` (`id`, `title`, `published`, `views`, `likes`, `dislikes`, `user_id`, `del_flg`) VALUES
(1, '亀はウサギよりも早いですか？', 1, 8, 3, 1, 'test', 0),
(2, 'スーパーサイヤ人は最強ですか？', 1, 9, 1, 1, 'test', 0),
(3, 'たこ焼きっておいしいですよね。', 1, 21, 2, 1, 'test', 0),
(4, '犬も歩けば棒に当たりますか？', 1, 25, 3, 2, 'test', 0);