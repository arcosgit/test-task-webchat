<?php
require __DIR__ . "/../vendor/autoload.php"; 
use App\Models\User;

if(!isset($_COOKIE["email"])){
    header("Location: index.php");
    exit();
}
$users = User::where("email", "!=", $_COOKIE["email"], "id, login");
?>
<!DOCTYPE html>
<html lang="ru">
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
                <?php foreach($users as $user): ?>
                <div class="chats_block">
                    <div class="chats_block_username"><?php echo $user['login'] ?></div>
                    <button class="chats_block_btn_sendmessage">Написать</button>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </main>
</body>
</html>