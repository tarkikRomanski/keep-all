<?php

namespace App\GraphQL\Mutation\Folder;

use App\GraphQL\Serializer\FolderSerializer;
use App\Models\Folder;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class UpdateFolderMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'updateFolder',
        'description' => 'Update the folder'
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
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'Id of the folder',
                'rules' => ['required', 'exists:folders,id']
            ],
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
        $folder = Folder::find($args['id']);

        $alias = [
            'name' => 'folder_name',
            'description' => 'folder_description',
            'parent' => 'parent_id'
        ];

        $updateFields = $this->transformFields($args, $alias);

        $folder->update($updateFields);

        return FolderSerializer::getInstance()->serialize($folder);
    }

    /**
     * Transform fields names by alias
     *
     * @param array $args
     * @param array $alias
     * @return array
     */
    private function transformFields(array $args, array $alias = [])
    {
        return array_column(array_map(function ($key, $value) use ($alias) {
            $key = isset($alias[$key]) ? $alias[$key] : $key;
            return [$key, $value];
        }, array_keys($args), $args), 1, 0);
    }
}