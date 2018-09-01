<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class FolderType extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'Folder',
        'description' => 'A folder that content gists'
    ];

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'The id of the folder'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the folder'
            ],
            'description' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Description for the folder'
            ],
            'color' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Color for the folder'
            ],
            'parent' => [
                'type' => Type::id(),
                'description' => 'Parent for the folder'
            ],
            'children' => [
                'type' => Type::listOf(GraphQL::type('Folder')),
                'description' => 'Children for the folder'
            ],
            'childrenQuantity' => [
                'type' => Type::int(),
                'description' => 'Quantity of the child elements'
            ],
            'gistsQuantity' => [
                'type' => Type::int(),
                'description' => 'Quantity of the gists into folder'
            ]
        ];
    }
}