<?php

use App\Models\Chat;

require __DIR__ . "/../vendor/autoload.php";
if(!isset($_GET['chatId']) || empty($_GET['chatId'])){
    header('Location: chats.php');
}
// $chat = Chat::where('id', '=', $_GET['chatId'])->get();
// if($chat[0]['first_user_id'] != $_COOKIE['id'] && $chat[0]['second_user_id'] != $_COOKIE['id']){
//     header('Location: chats.php');
// }
// $chat_with_user_id = $chat[0]['first_user_id'] == $_COOKIE['id'] ? 
$chat = Chat::select('first_user_id, second_user_id, login')
        ->join('users', 'chats.first_user_id = users.id AND chats.second_user_id = users.id')->get();
print_r($chat);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональный чат</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/personal-chat.css">
</head>
<body>
    <main>
        <div class="chat">
            <div class="chat_upper_block">Чат с Alex</div>
            <div class="chat_messages_block">
                <div class="chat_message">
                    <div class="chat_message_username">Alex</div>
                    <div class="chat_message_text">Сообщение</div>
                </div>
            </div>
            <div class="chat_down_block">
                <input class="chat_input_message" type="text" id="message" placeholder="Впишите сообщение" required>
                <button class="chat_btn_send_message">Отправить</button>
            </div>
        </div>
    </main>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
        let chatId = <?= $_GET['chatId'] ?>;
        $('.chat_btn_send_message').on('click', function(){
            $.ajax({
                url: "send_message.php",
                type: "POST",
                data: { chat_id: chatId, message: $('.chat_input_message').val()  },
                success: function(response){
                    let data = JSON.parse(response);
                    console.log(data);
                }
            });
        });
    </script>
</body>
</html>