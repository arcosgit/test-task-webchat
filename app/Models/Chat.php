<?php
namespace App\Models;

use App\Services\DB\DBService;
class Chat extends DBService{
    protected static string $table = "chats";
}