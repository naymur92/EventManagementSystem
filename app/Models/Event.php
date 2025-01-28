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
}
