<?php
require __DIR__ . "/../vendor/autoload.php"; 

use App\Models\User;

function store(){
    if(isset($_POST['login'], $_POST['email'], $_POST['password'], $_POST['password_confirm'])){
        $tryFindEmail = User::where('email', '=', $_POST['email']);
        $tryFindLogin = User::where('login', '=', $_POST['login']);
        if(count($tryFindLogin) > 0){
            $_GET['error_login'] = "Данный логин занят";
            return;
        }
        if(count($tryFindEmail) > 0){
            $_GET['error_email'] = "Данная почта уже зарегистрирована";
            return;
        }
        $result = User::insert([
            'login' => $_POST['login'],
            'email'=> $_POST['email'],
            'password'=> password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]);
        if($result){
            setcookie("email", $_POST['email']);
            header("Location: chats.php");
            exit();
        }
    }
}
store();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/public/assets/css/auth.css">
</head>
<body>
    <main>
        <form class="form" method="POST">
            <div class="form_title">Регистрация в Веб-чат</div>
            <div class="form_text">Логин</div>
            <input value="<?php echo isset($_POST['login']) ? $_POST['login']: '' ?>" class="form_input" type="text" name="login" placeholder="Придумайте логин" required>
            <?php if(isset($_GET['error_login']) && !empty($_GET['error_login'])): ?>
                <div class="form_text_error">Данный логин занят</div>
            <?php endif ?>
            <div class="form_text">Email</div>
            <input value="<?php echo isset($_POST['email']) ? $_POST['email']: '' ?>"  class="form_input" type="email" name="email" id="email" placeholder="Придумайте почту" required>
            <?php if(isset($_GET['error_email']) && !empty($_GET['error_email'])): ?>
                <div class="form_text_error">Данная почта уже зарегистрирована</div>
            <?php endif ?>
            <div class="form_text">Пароль</div>
            <input value="<?php echo isset($_POST['password']) ? $_POST['password']: '' ?>"  class="form_input" type="password" name="password" id="password" placeholder="Придумайте пароль" required>
            <input value="<?php echo isset($_POST['password_confirm']) ? $_POST['password_confirm']: '' ?>" class="form_input" type="password" name="password_confirm" id="password_confirm" placeholder="Повторите пароль" required>
            <div class="form_error_password"></div>
            <div class="form_block">
                <button type="submit" class="form_submit">Зарегистрироваться</button>
                <a href="/public/index.php">Уже есть аккаунт</a>
            </div>
        </form>
    </main>
    <script src="/public/assets/js/jquery-3.7.1.slim.min.js"></script>
    <!-- <script src="/public/assets/js/registration.js"></script> -->
</body>
</html>