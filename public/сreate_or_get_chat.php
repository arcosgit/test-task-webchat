<?php
require __DIR__ . "/../vendor/autoload.php";
use App\Models\Chat;

if(!isset($_COOKIE["auth_token"])){
    echo json_encode(["success" => false, "message" => "Вы не авторизованы"]);
    exit();
}
$secondUserId = $_POST["second_user_id"] ?? null;
if(!$secondUserId || $secondUserId == $_COOKIE["id"]){
    echo json_encode(["success" => false, "message" => "Неверные данные"]);
    exit();
}

$chat = Chat::where("first_user_id", "=", $_COOKIE["id"])
        ->where("second_user_id", "=", $secondUserId)
        ->whereOr("second_user_id", "=", $_COOKIE["id"])
        ->where("first_user_id", "=", $secondUserId)->get();
        
$chatId = null;
if(count($chat) > 0){
    $chatId = $chat[0]["id"];
} else {
    Chat::insert([
        "first_user_id" => $_COOKIE["id"],
        "second_user_id" => $secondUserId
    ]);
    $chatId = Chat::where("first_user_id", "=", $_COOKIE["id"], "id")->get()[0]["id"];
}

echo json_encode(["success" => true, "chat_id" => $chatId]);
