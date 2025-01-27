<?php

namespace App\Models;

class HostDetail extends BaseModel
{
    protected $table = 'host_details';
    protected $primaryKey = 'id';
    protected array $fillable = ['user_id', 'description', 'location'];
}
