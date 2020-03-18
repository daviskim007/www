<?php

require_once "Facebook/autoload.php";
require_once "Facebook/Facebook.php";

$con = mysqli_connect("localhost","root","kkj31008!","memory_game");

$fb = new Facebook\Facebook([
  'app_id' => '3365000726849357',
  'app_secret' => '87c389a3fe4c15ebe0b74e11f6b94411',
  'default_graph_version' => 'v6.0',
  ]);