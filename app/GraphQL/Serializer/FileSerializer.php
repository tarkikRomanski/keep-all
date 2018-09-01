<?php

namespace App\GraphQL\Serializer;

class FileSerializer
{
    /**
     * @var FileSerializer|null
     */
    private static $instance = null;

    /**
     * FileSerializer constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return FileSerializer
     */
    public static function getInstance() : FileSerializer
    {
        if (self::$instance === null) {
            self::$instance = new FileSerializer();
        }

        return self::$instance;
    }

    /**
     * @param object $file
     * @return array
     */
    public function serialize(object $file) : array
    {
        return [
            'id' => $file->filename,
            'name' => $file->filename,
            'rawUrl' => $file->raw_url,
            'size' => humanSize($file->size)
        ];
    }
}