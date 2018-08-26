<?php

namespace App\GraphQL\Mutation\Folder;

use App\Models\Folder;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class DeleteFolderMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'deleteFolder',
        'description' => 'Delete the folder by id'
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
            ]
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

        $folder->delete();

        return ['id' => $args['id']];
    }
}