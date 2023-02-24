<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        "id",
        "code",
        'email',
        "user_name",
        "full_name",
        "department",
        "devision",
        "roles",
        "subordinates",
        "groups",
        "permisions",
        "managements"
    ];
}
