<?php
if(!isset($_COOKIE["email"])){
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чаты</title>
    <link rel="stylesheet" href="/public/assets/css/chats.css">
</head>
<body>
    <main>
        <div>
            <div class="users_text">Пользователи</div>
            <div class="chats">
                <div class="chats_block">
                    <div class="chats_block_username">Имя</div>
                    <button class="chats_block_btn_sendmessage">Написать</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>