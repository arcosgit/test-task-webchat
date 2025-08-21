<?php
namespace App\Models;

use App\Services\DB\DBService;
class UserToken extends DBService {
    protected static string $table = "user_tokens";
}