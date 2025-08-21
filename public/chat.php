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
    </script>
</body>
</html>