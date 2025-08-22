<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";
use App\Models\ChatMessage;
if(!isset($_SESSION['auth_token'])){
    echo json_encode(["success" => false, "message" => "Вы не авторизованы"]);
    exit();
}
$chat_id = $_POST["chat_id"] ?? null;
$message = $_POST["message"];
if($chat_id == null || $message == null){
    echo json_encode(["success"=> false,"message"=> ""]);
} else {
    ChatMessage::insert([
        'chat_id' => $chat_id,
        'sender_id' => $_SESSION['id'],
        'message' => $message
    ]);
    echo json_encode(["success"=> true,"message"=> $message, 'chat_id' => $chat_id]);
}
