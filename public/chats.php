<?php
require __DIR__ . "/../vendor/autoload.php"; 
use App\Models\User;

if(!isset($_COOKIE["auth_token"])){
    header("Location: index.php");
    exit();
}
$users = User::where("id", "!=", $_COOKIE["id"], "id, login")->get();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чаты</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/chats.css">
</head>
<body>
    <main>
        <div>
            <div class="users_text">Пользователи</div>
            <div class="chats">
                <?php foreach($users as $user): ?>
                <div class="chats_block">
                    <div class="chats_block_username"><?php echo $user['login'] ?></div>
                    <button class="chats_block_btn_sendmessage" data-id="<?php echo $user['id'] ?>">Написать</button>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </main>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/moveToChat.js"></script>
</body>
</html>
