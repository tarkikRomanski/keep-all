<?php

namespace App\GraphQL\Serializer;

use App\Models\Folder;
use App\Models\Gist;

class GistSerializer
{
    /**
     * @var GistSerializer|null
     */
    private static $instance = null;

    /**
     * GistSerializer constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return GistSerializer
     */
    public static function getInstance() : GistSerializer
    {
        if (self::$instance === null) {
            self::$instance = new GistSerializer();
        }

        return self::$instance;
    }

    /**
     * Return the serialized data
     *
     * @param object $gist
     * @return array
     */
    public function serialize(object $gist) : array
    {
        $returnData = [
            'gist' => $gist->id,
            'description' => $gist->description,
            'htmlUrl' => $gist->html_url,
            'files' => array_map(function($file){
                return FileSerializer::getInstance()->serialize($file);
            }, (array)$gist->files),
            'createdAt' => $gist->created_at,
            'owner' => GistUserSerializer::getInstance()->serialize($gist->owner)
        ];

        $returnData['id'] = isset($gist->local_id) 
            ? $gist->local_id 
            : null;

        $returnData['user'] = isset($gist->local_user) 
            ? $gist->local_user 
            : null;

        $returnData['folder'] = isset($gist->folder) 
            ? FolderSerializer::getInstance()->serialize($gist->folder) 
            : null;

        return $returnData;
    }

    /**
     * Return collection of the serialized data
     *
     * @param array $gists
     * @return array
     */
    public function collection(array $gists) : array
    {
        return array_map(function($gist) {
            return $this->serialize($gist);
        }, $gists);
    }
}