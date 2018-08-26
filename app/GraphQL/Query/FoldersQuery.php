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
                'name' => 'id',
                'type' => Type::id()
            ],
            'parent' => [
                'name' => 'parent',
                'type' => Type::id()
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

        foreach ($args as $column => $value) {
            $column = $column == 'parent' ? 'parent_id': $column;

            $query = $query->where($column, $value);
        }

        return $query->get()->map(function (Folder $folder) {
            return FolderSerializer::getInstance()->serialize($folder);
        });
    }
}