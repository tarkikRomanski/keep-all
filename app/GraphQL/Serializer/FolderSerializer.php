<?php

namespace App\GraphQL\Serializer;

use App\Models\Folder;

class FolderSerializer
{
    /**
     * @var FolderSerializer|null
     */
    private static $instance = null;

    /**
     * FolderSerializer constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return FolderSerializer
     */
    public static function getInstance() : FolderSerializer
    {
        if (self::$instance === null) {
            self::$instance = new FolderSerializer();
        }

        return self::$instance;
    }

    /**
     * @param Folder $folder
     * @return array
     */
    public function serialize(Folder $folder) : array
    {
        return [
            'id' => $folder->id,
            'name' => $folder->folder_name,
            'description' => $folder->folder_description,
            'color' => $folder->color,
            'parent' => $folder->parent_id
        ];
    }
}