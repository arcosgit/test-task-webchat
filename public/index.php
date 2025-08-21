<?php 
require __DIR__ . "/../vendor/autoload.php"; 

use App\Models\User;
use App\Models\UserToken;

function auth(){
    if(isset($_POST['email'], $_POST['password'])){
        $user = User::where('email', '=', $_POST['email'])->get();
        if(count($user) == 0){
            $_GET['error_email'] = "Пользователь не найден";
            return;
        }
        if(password_verify($_POST["password"], $user[0]['password'])){
            $token = bin2hex(random_bytes(64));
            UserToken::delete("user_id", "=", $user[0]['id']);
            UserToken::insert([
                'user_id' => $user[0]['id'],
                'token' => $token
            ]);
            setcookie("auth_token", $token);
            setcookie("id", $user[0]['id']);
            header("Location: chats.php");
            exit();
        } else {
            $_GET["error_passsword"] = true;
        }
    }
}
auth()
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <main>
        <form class="form" action="" method="POST">
            <div class="form_title">Вход в Веб-чат</div>
            <div class="form_text">Email</div>
            <input value="<?php echo isset($_POST['email']) ? $_POST['email']: '' ?>" class="form_input" type="email" name="email" id="email" placeholder="Впишите почту" required>
            <?php if(isset($_GET['error_email']) && !empty($_GET['error_email'])): ?>
                <div class="form_text_error">Пользователь не найден</div>
            <?php endif ?>
            <div class="form_text">Пароль</div>
            <input value="<?php echo isset($_POST['password']) ? $_POST['password']: '' ?>" class="form_input" type="password" name="password" id="password" placeholder="Впишите пароль" required>
            <?php if(isset($_GET['error_passsword']) && !empty($_GET['error_passsword'])): ?>
                <div class="form_text_error">Неверный пароль</div>
            <?php endif ?>
            <div class="form_block">
                <button type="submit" class="form_submit">Войти</button>
                <a href="registration.php">Нет аккаунта</a>
            </div>
        </form>
    </main>
</body>
</html>