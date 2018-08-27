<?php

namespace App\GraphQL\Query;

use App\GraphQL\Serializer\GistSerializer;
use App\Models\Gist;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class GistsQuery extends Query
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'gists',
        'description' => 'Get gists'
    ];

    /**
     * @return GraphQL\Type\Definition\ListOfType|null
     */
    public function type()
    {
        return Type::listOf(GraphQL::type('Gist'));
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
            'gist' => [
                'name' => 'gist',
                'type' => Type::string()
            ],
            'folder' => [
                'name' => 'folder',
                'type' => Type::id()
            ]
        ];
    }

    /**
     * @param $root
     * @param $args
     * @return Gist[]|\Illuminate\Database\Eloquent\Collection
     */
    public function resolve($root, $args)
    {
        $query = Gist::query();

        $alias = [
            'gist' => 'gist_id',
            'folder' => 'folder_id',
        ];
        $args = $this->transformFields($args, $alias);

        foreach ($args as $column => $value) {
            $query = $query->where($column, $value);
        }

        return $query->get()->map(function (Gist $gist) {
            return GistSerializer::getInstance()->serialize($gist);
        });
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