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
     * @param Gist $gist
     * @return array
     */
    public function serialize(Gist $gist) : array
    {
        $returnData = [
            'id' => $gist->id,
            'gist' => $gist->gist_id,
            'user' => $gist->user_id,
        ];

        $folder = $gist->folder()->getResults();

        if($folder !== null) {
            $returnData['folder'] = FolderSerializer::getInstance()->serialize($gist->folder()->getResults());
        }

        return $returnData;
    }
}