<?php
namespace controller\login;

function get(){
  require_once(dirname(__DIR__) . "/views/login.php");
}

function post(){
  echo 'post methodを受け取りました。';
}
