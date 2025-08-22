<?php 
session_start();
require __DIR__ . "/../vendor/autoload.php";

use App\Models\Chat;
use App\Models\ChatMessage;
if(!isset($_SESSION['auth_token'])){
    echo json_encode(["success" => false, "message" => "Вы не авторизованы"]);
    exit();
}
$chat_id = $_POST["chat_id"] ?? null;
$chat = Chat::select('chats.id as chat_id, first_user_id, second_user_id, login')
        ->join('users', 'chats.first_user_id = users.id or chats.second_user_id = users.id')
        ->where("chats.id", "=", $chat_id)->get();
if($chat[0]['first_user_id'] != $_SESSION['id'] && $chat[0]['second_user_id'] != $_SESSION['id']){
    echo json_encode(["success" => false, "message" => "Доступ запрещён"]);
    exit();
}
$messages = ChatMessage::select("login, message, chat_messages.id AS message_id")
            ->join("users", "chat_messages.sender_id = users.id")
            ->where("chat_messages.chat_id", "=", $chat_id)
            ->orderBy("message_id")->get();
echo json_encode(["success" => true, "messages" => $messages]);
exit();