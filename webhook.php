<?php
include("api.php");
$a = new downloadgram();
$botToken = 'YOUR TOKEN';
$a->BotToken = $botToken;
$update = json_decode(file_get_contents("php://input"), TRUE);

if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $message = $update["message"]["text"];
    $userInfo = json_decode(file_get_contents("https://api.telegram.org/bot$botToken/getChat?chat_id=$chatId"), true);

    if ($userInfo && isset($userInfo['ok']) && $userInfo['ok']) {
        $username = $userInfo['result']['username'];
        $first_name = $userInfo['result']['first_name'];
        if(isset($username) and $username !== null){
            $a->username = $username;
        }else{
             $a->username = $first_name; 
        }
      
    }
    $a->chatid = $chatId;
    echo $a->getCheck($message);
} else {
  //error
   die();
}
?>
