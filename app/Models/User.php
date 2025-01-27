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

    /**
     * Get the HostDetail associated with the user.
     *
     * @return HostDetail|null
     */
    public function getHostDetail(): ?HostDetail
    {
        if ($this->type !== 2) {
            return null;
        }

        $hostDetails = (new HostDetail())->where('user_id', '=', $this->{$this->primaryKey})->get();

        return !empty($hostDetails) ? HostDetail::makeInstance($hostDetails[0]) : null;
    }

    /**
     * Save HostDetail data if applicable.
     *
     * @param array $hostDetailData
     * @return void
     */
    public function saveHostDetail(array $hostDetailData): void
    {
        if ($this->type !== 2) {
            return;
        }

        $hostDetail = $this->getHostDetail();

        if ($hostDetail) {
            $hostDetail->update($hostDetailData);
        } else {
            $hostDetailData['user_id'] = $this->{$this->primaryKey};
            (new HostDetail())->insert($hostDetailData);
        }
    }
}
