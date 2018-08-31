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
     * @param object $gist
     * @return array
     */
    public function serialize(object $gist) : array
    {
        $returnData = [
            'gist' => $gist->id,
            'htmlUrl' => $gist->html_url
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
}