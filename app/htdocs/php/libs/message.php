<?php
namespace lib;

use model\AbstractModel;
use Throwable;

//sessionにメッセージを格納して表示するクラス。sessionに格納しないとメッセージが表示されない（205講義参考）
class Msg extends AbstractModel{
    protected static $SESSION_NAME = '_msg';
    //メッセージの種類を定義
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    // このメソッドの引数に値を渡すとSESSIONにメッセージを登録する
    //引数の$type...上記で定義したのメッセージの種類
    //      $msg....SESSIONに登録したいメッセージ
    public static function push($type, $msg) {
      //SESSIONに配列がなかったとき（init()が呼び出されていない（1回目の実行））init()でSESSIONに配列を作成
        if(!is_array(static::getSession())){
            static::init();
        }

        $msgs = static::getSession();
        // $msg(連想配列)のキー（$type）に値を格納する
        $msgs[$type][] = $msg;
        static::setSession($msgs);
        //$msgの連想配列は下記のようになる
      //   $msgs = array(
      //     'error' => array(
      //         'メッセージ1',
      //         'メッセージ2',
      //         // ... 他のエラーメッセージ
      //     ),
      //     'success' => array(
      //         'メッセージA',
      //         'メッセージB',
      //         // ... 他の成功メッセージ
      //     ),
      //     // ... 他のメッセージの種類
      // );
    }

    // $msgsの連想配列に登録されたmsg（値）を取り出す関数
    public static function flush() {
      try {
        $msgs_with_type = static::getSessionAndFlush() ?? [];

        echo '<div id="messages">';

        foreach($msgs_with_type as $type => $msgs){
          if($type === static::DEBUG && !DEBUG){
            continue;
          }

          // 渡ってきた$typeによってエラーの色を変える
          $color = $type === static::INFO ? 'alert-info' : 'alert-danger';

          foreach($msgs as $msg){
            // ログイン失敗したらalertで赤色でエラーを表示
            echo "<div class='alert alert-danger'>{$msg}</div>";
          }
        }

        echo '</div>';
        
      } catch (Throwable $e){
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::DEBUG, 'Msg::flushで例外が発生しました');
      }
    }

    //SESSIONの初期化
    //SESSIONの中に配列を作成
    private static function init(){
      static::setSession([
        static::ERROR => [],
        static::INFO => [],
        static::DEBUG => [],
      ]);
    }
}
?>