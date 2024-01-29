<?php
include("api.php");
$a = new downloadgram();
$a->BotToken = 'YOUR TOKEN';
$update = json_decode(file_get_contents("php://input"), TRUE);

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $a->chatid = $chatId;
    echo $a->getCheck($message);
} else {
  //error
   die();
}
?>
