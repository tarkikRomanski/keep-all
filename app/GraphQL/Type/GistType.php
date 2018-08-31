<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class GistType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Gist',
        'description' => 'A gist'
    ];

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'The id of the gist'
            ],
            'gist' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id on gist.github'
            ],
            'user' => [
                'type' => Type::id(),
                'description' => 'Owner id'
            ],
            'folder' => [
                'type' => GraphQL::type('Folder'),
                'description' => 'The folder of the gist'
            ],
            'htmlUrl' => [
                'type' => Type::string(),
                'description' => 'The url of the gist'
            ]
        ];
    }
}