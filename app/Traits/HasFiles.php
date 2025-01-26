<?php

namespace App\Traits;

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
        return (new File())->where('operation_name', '=', $this->getTable())
            ->where('table_id', '=', $this->{$this->getPrimaryKey()})
            ->get();
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
    //     return (new File())->where('operation_name', $this->getTable())
    //         ->where('table_id', $this->{$this->getPrimaryKey()})
    //         ->delete();
    // }
}
