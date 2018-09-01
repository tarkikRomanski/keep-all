<?php

namespace App\GraphQL\Input;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Type as GraphQLType;

class FileInput extends GraphQLType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'File',
        'description' => 'Input: The file in a gist'
    ];

    /**
     * @var bool
     */
    protected $inputObject = true;

    /**
     * @return array
     */
    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Name of the file'
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Content of the file'
            ]
        ];
    }
}