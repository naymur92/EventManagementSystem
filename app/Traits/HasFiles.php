<?php

namespace App\Traits;

use App\Core\DB;
use App\Models\File;

trait HasFiles
{
    /**
     * Retrieve all files associated with the model.
     *
     * @return array
     */
    public function getFiles(): array
    {
        // return (new File())->where('operation_name', '=', $this->getTable())
        //     ->where('table_id', '=', $this->{$this->getPrimaryKey()})
        //     ->where('deleted_at', 'IS', null)
        //     ->get();

        $sql = "SELECT * FROM files WHERE operation_name = ? AND table_id = ? AND deleted_at IS NULL ORDER BY created_at ASC";
        $stmt = DB::query($sql, [$this->getTable(), $this->{$this->getPrimaryKey()}]);

        return $stmt->fetchAll();
    }

    /**
     * Save a file associated with the model.
     *
     * @param array $data
     * @return bool
     */
    public function saveFile(array $data): bool
    {
        $fileData = array_merge($data, [
            'operation_name' => $this->getTable(),
            'table_id' => $this->{$this->getPrimaryKey()},
        ]);

        return (new File())->saveFileIntoDB($fileData);
    }


    /**
     * Delete all files associated with the model.
     *
     * @return bool
     */
    // public function deleteAllFiles(): bool
    // {
    //     return (new File())->where('operation_name', '=', $this->getTable())
    //         ->where('table_id', '=', $this->{$this->getPrimaryKey()})
    //         ->delete();
    // }
}
