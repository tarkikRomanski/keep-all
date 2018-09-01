<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class GistUserType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'GistUser',
        'description' => 'The user on the gist'
    ];

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'login' => [
                'type' => Type::string(),
                'description' => 'Login of the gist user'
            ],
            'url' => [
                'type' => Type::string(),
                'description' => 'The url to user page on gist'
            ],
            'avatar' => [
                'type' => Type::string(),
                'description' => 'The avatar of the gist user'
            ]
        ];
    }
}