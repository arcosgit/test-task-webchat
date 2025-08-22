<?php
namespace App\Models;

use App\Services\DB\DBService;
class ChatMessage extends DBService{
    protected static string $table = "chat_messages";
}