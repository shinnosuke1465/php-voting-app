USE app_db;

START TRANSACTION;

SET time_zone = "+09:00";

-- ログインアカウントテーブルにデータを登録する定義

INSERT INTO `users` (`id`, `pwd`, `nickname`, `del_flg`) VALUES
('test', '$2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK', 'テストユーザー', 0);
COMMIT;
