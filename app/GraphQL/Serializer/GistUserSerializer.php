<?php

namespace App\GraphQL\Serializer;

class GistUserSerializer
{
    /**
     * @var GistUserSerializer|null
     */
    private static $instance = null;

    /**
     * GistUserSerializer constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return GistUserSerializer
     */
    public static function getInstance() : GistUserSerializer
    {
        if (self::$instance === null) {
            self::$instance = new GistUserSerializer();
        }

        return self::$instance;
    }

    /**
     * @param object $owner
     * @return array
     */
    public function serialize(object $owner) : array
    {
        return [
            'login' => $owner->login,
            'url' => $owner->html_url,
            'avatar' => $owner->avatar_url
        ];
    }
}