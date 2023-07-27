<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>みんなのアンケート</title>
    <!-- <link rel="stylesheet" href="<?php echo BASE_CSS_PATH ?>sample.css"> -->
</head>
<body>
<?php
    use lib\Auth;
    use lib\Msg;

    //msgクラスのflushメソッドが実行されてlogin.phpで実行された Msg::push(Msg::INFO,'認証成功');のコードの認証成功が表示される
    Msg::flush();

    ?>