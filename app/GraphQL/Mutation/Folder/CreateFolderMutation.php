<?php

namespace App\GraphQL\Mutation\Folder;

use App\GraphQL\Serializer\FolderSerializer;
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
                'type' => Type::string(),
                'description' => 'Name of the folder',
                'rules' => ['required', 'max:100', 'min:3']
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description for the folder',
                'rules' => ['required', 'max:100', 'min:3']
            ],
            'color' => [
                'type' => Type::string(),
                'description' => 'Color for the folder',
                'rules' => ['regex:/#[0-9A-Fa-f]{6}/']
            ],
            'parent' => [
                'type' => Type::id(),
                'description' => 'Parent for the folder',
                'rules' => ['numeric', 'exists:folders,id']
            ],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return mixed
     */
    public function resolve($root, $args)
    {
        $createData = [
            'folder_name' => $args['name'],
            'folder_description' => $args['description'],
            'color' => isset($args['color']) ? $args['color'] : '#333333',
            'parent_id' => isset($args['parent']) ? $args['parent'] : null,
            'user_id' => 5,
        ];

        $folder = Folder::create($createData);

        return FolderSerializer::getInstance()->serialize($folder);
    }
}