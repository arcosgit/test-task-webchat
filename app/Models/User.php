<?php
namespace App\Models;
use App\Services\DB\DBService;

class User extends DBService{
    protected static string $table = "users";
}