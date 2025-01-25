<?php

namespace App\Models;

class User extends BaseModel
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected array $fillable = ['name', 'email', 'mobile', 'status', 'password', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
