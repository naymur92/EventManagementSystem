<?php

namespace App\Models;

use App\Traits\HasFiles;

class User extends BaseModel
{
    use HasFiles;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected array $protected = ['password'];
    protected array $fillable = ['user_id', 'name', 'email', 'mobile', 'type', 'status', 'password', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    /**
     * Retrieving user profile picture.
     *
     * @return array|null
     */
    public function getProfilePicture(): array|null
    {
        $files = $this->getFiles();

        return array_filter($files, fn($file) => $file['fileinfo'] === 'profile_picture')[0] ?? null;
    }
}
