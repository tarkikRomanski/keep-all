<?php

namespace App\GraphQL\Query;

use App\GraphQL\Serializer\FolderSerializer;
use App\Models\Folder;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class FoldersQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'folders',
        'description' => 'Get folders'
    ];

    /**
     * @return GraphQL\Type\Definition\ListOfType|null
     */
    public function type()
    {
        return Type::listOf(GraphQL::type('Folder'));
    }

    /**
     * @return array
     */
    public function args()
    {
        return [
            'id' => [
                'description' => 'Id of the folder',
                'type' => Type::id()
            ],
            'parent' => [
                'description' => 'Parent of the folder',
                'type' => Type::id()
            ],
            'onlyRoot' => [
                'description' => 'Show only root folders',
                'type' => Type::boolean()
            ]
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return Folder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function resolve($root, $args)
    {
        $query = Folder::query();

        if (isset($args['parent'])) {
            $query = $query->where('parent_id', $args['parent']);
        }

        if (isset($args['id'])) {
            $query = $query->where('id', $args['id']);
        }

        if (isset($args['onlyRoot']) &&  $args['onlyRoot']) {
            $parent = isset($args['parent']) ? $args['parent'] : null;

            $query = $query->where('parent_id', $parent);
        }

        return $query->get()->map(function (Folder $folder) {
            return FolderSerializer::getInstance()->serialize($folder);
        });
    }
}