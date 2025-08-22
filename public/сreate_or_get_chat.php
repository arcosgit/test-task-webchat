<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";
use App\Models\Chat;

if(!isset($_SESSION['auth_token'])){
    echo json_encode(["success" => false, "message" => "Вы не авторизованы"]);
    exit();
}
$second_user_id = $_POST["second_user_id"] ?? null;
if(!$second_user_id || $second_user_id == $_SESSION['id']){
    echo json_encode(["success" => false, "message" => "Неверные данные"]);
    exit();
}

$chat = Chat::where("first_user_id", "=", $_SESSION['id'])
        ->where("second_user_id", "=", $second_user_id)
        ->whereOr("second_user_id", "=", $_SESSION['id'])
        ->where("first_user_id", "=", $second_user_id)->get();
        
$chat_id = null;
if(count($chat) > 0){
    $chat_id = $chat[0]["id"];
} else {
    Chat::insert([
        "first_user_id" => $_SESSION['id'],
        "second_user_id" => $second_user_id
    ]);
    $chat_id = Chat::where("first_user_id", "=", $_SESSION['id'], "id")
    ->where("second_user_id", "=", $second_user_id)->get()[0]["id"];
}

echo json_encode(["success" => true, "chat_id" => $chat_id]);
