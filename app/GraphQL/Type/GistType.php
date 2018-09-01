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
            'description' => [
                'type' => Type::string(),
                'description' => 'Description of the gist'
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
            ],
            'files' => [
                'type' => Type::listOf(GraphQL::type('File')),
                'description' => 'Files of the gist'
            ],
            'createdAt' => [
                'type' => Type::string(),
                'description' => 'Date of the creation the gist'
            ],
            'owner' => [
                'type' => GraphQL::type('GistUser'),
                'description' => 'Owner of the gist'
            ]
        ];
    }
}