-- dbにアクセスするユーザーの定義。test_user...ユーザー名。pwd...パスワード
CREATE USER 'test_user' @'localhost' IDENTIFIED BY 'pwd';

-- 権限の設定。test__userはapp_dbに対して全ての権限を持つ
GRANT ALL PRIVILEGES ON app_db.* TO 'test_user' @'localhost' WITH GRANT OPTION;

-- 上記の内容をsqlに反映させる
FLUSH PRIVILEGES;