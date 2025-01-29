<?php

namespace App\Models;

use App\Traits\HasFiles;

class Event extends BaseModel
{
    use HasFiles;

    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected array $fillable = ['name', 'location', 'google_map_location', 'description', 'start_time', 'end_time', 'max_capacity', 'registration_fee', 'current_capacity', 'status', 'user_id', 'created_at', 'updated_at'];


    /**
     * Get banner image
     *
     * @return array|null
     */
    public function getBanner(): array|null
    {
        $files = $this->getFiles();

        return array_filter($files, fn($file) => $file['fileinfo'] === 'banner_image')[0] ?? null;
    }


    /**
     * Get host details for event
     *
     * @return array
     */
    public function getHostDetail(): array
    {
        $hostInfo = (new User())->where('user_id', '=', $this->user_id)->get();

        $user = User::makeInstance($hostInfo[0]);
        $hostExtraInfo = (new HostDetail())->where('user_id', '=', $this->user_id)->get();

        $hostProfilePicture = $user->getProfilePicture();

        $returnData = array();
        $returnData['info'] = $hostInfo[0] ?? array();
        $returnData['extra_info'] = $hostExtraInfo[0] ?? array();
        $returnData['profile_photo'] = $hostProfilePicture;

        return $returnData;
    }
}
