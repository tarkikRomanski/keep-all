<?php

namespace App\GraphQL\Mutation;

use App\Models\Folder;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class CreateFolderMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'createFolder',
        'description' => 'Create a new folder'
    ];

    public function type()
    {
        return GraphQL::type('Folder');
    }

    /**
     * @return array
     */
    public function args()
    {
        return [
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
        ];
    }

    public function resolve($root, $args)
    {
        $folder = Folder::create([
            'folder_name' => $args['name'],
            'folder_description' => $args['description'],
            'color' => $args['color'],
            'parent_id' => isset($args['parent']) ? $args['parent'] : null,
            'user_id' => 5,
        ]);
        return $folder;
    }
}