<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class FileType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'File',
        'description' => 'The file in a gist'
    ];

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::id(),
                'description' => 'Id of the file'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the file'
            ],
            'rawUrl' => [
                'type' => Type::string(),
                'description' => 'Url to content of the file'
            ],
            'size' => [
                'type' => Type::string(),
                'description' => 'Size of the file'
            ]
        ];
    }
}