<?php 
require __DIR__ . "/../vendor/autoload.php"; 

use App\Models\User;

function auth(){
    if(isset($_POST['email'], $_POST['password'])){
        $tryFindEmail = User::where('email', '=', $_POST['email']);
        if(count($tryFindEmail) == 0){
            $_GET['error_email'] = "Пользователь не найден";
            return;
        }
        if(password_verify($_POST["password"], $tryFindEmail[0]['password'])){
            setcookie("email", $_POST["email"]);
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
    <link rel="stylesheet" href="/public/assets/css/auth.css">
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
                <a href="/public/registration.php">Нет аккаунта</a>
            </div>
        </form>
    </main>
</body>
</html>