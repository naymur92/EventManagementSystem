<?php

namespace App\Models;

class File extends BaseModel
{
    protected $table = 'files';
    protected $primaryKey = 'file_id';
    protected array $fillable = ['operation_name', 'table_id', 'filepath', 'filename', 'fileinfo', 'created_by', 'deleted_by', 'created_at', 'deleted_at'];

    /**
     * Retrieve all files associated with the model.
     * This can be overridden in individual models.
     *
     * @param BaseModel $model
     * @return array
     */
    public function getFiles(BaseModel $model): array
    {
        return $this->where('operation_name', '=', $model->getTable())
            ->where('table_id', '=', $model->{$model->getPrimaryKey()})
            ->get();
    }

    /**
     * Save a file record into the database.
     *
     * @param array $data
     * @return bool
     */
    public function saveFileIntoDB(array $data): bool
    {
        return $this->insert($data);
    }

    /**
     * Delete a file record from the database.
     *
     * @param int $fileId
     * @return bool
     */
    // public function deleteFileFromDB(int $fileId): bool
    // {
    //     $file = $this->find($fileId);
    //     if ($file) {
    //         return $file->delete();
    //     }
    //     return false;
    // }
}
