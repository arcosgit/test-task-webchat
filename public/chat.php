<?php
require __DIR__ . "/../vendor/autoload.php";
use App\Models\Chat;
if(!isset($_GET['chatId']) || empty($_GET['chatId'])){
    header('Location: chats.php');
}
$chat = Chat::select('chats.id as chat_id, first_user_id, second_user_id, login')
        ->join('users', 'chats.first_user_id = users.id or chats.second_user_id = users.id')
        ->where("chats.id", "=", $_GET['chatId'])->get();
if($chat[0]['first_user_id'] != $_COOKIE['id'] && $chat[0]['second_user_id'] != $_COOKIE['id']){
    header('Location: chats.php');
}
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
            <div class="chat_upper_block">Чат с <?= $chat[0]['login'] == $_COOKIE['login'] ? $chat[1]['login'] : $chat[0]['login'] ?></div>
            <div class="chat_messages_block"></div>
            <div class="chat_down_block">
                <input class="chat_input_message" type="text" id="message" placeholder="Впишите сообщение" required>
                <button class="chat_btn_send_message">Отправить</button>
            </div>
        </div>
    </main>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
        let chatId = <?= $_GET['chatId'] ?>;
        let messagesIds = [];
        const sendMessage = () => {
            $.ajax({
                url: "send_message.php",
                type: "POST",
                data: { chat_id: chatId, message: $('.chat_input_message').val()  },
                success: function(response){
                    let data = JSON.parse(response);
                    $('.chat_input_message').val("");
                }
            });
        }
        $('.chat_btn_send_message').on('click', ()=>sendMessage());
        $('.chat_input_message').keydown(function(e){
            if(e.key === 'Enter'){
                sendMessage();
            }
        });
        const getMessages = () => {
            $.ajax({
                url: "get_messages.php",
                type: "POST",
                data: { chat_id: chatId},
                success: function(res){
                    let data = JSON.parse(res);
                    let chatBlock = $('.chat_messages_block');
                    data.messages.forEach(message => {
                        if(!messagesIds.includes(message.message_id)){
                            chatBlock.append(`<div class='chat_message'><div class='chat_message_username'>${message.login}</div><div class='chat_message_text'>${message.message}</div></div>`);
                            messagesIds.push(message.message_id);
                            chatBlock.animate({
                                scrollTop: chatBlock.prop('scrollHeight')
                            })
                        }
                    });
                }
            })
        }
        setInterval(getMessages, 1000);
        getMessages();
    </script>
</body>
</html>