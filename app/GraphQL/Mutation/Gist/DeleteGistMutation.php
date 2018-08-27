<?php

namespace App\GraphQL\Mutation\Gist;

use App\Models\Gist;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class DeleteGistMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'deleteGist',
        'description' => 'Delete the gist by id'
    ];

    public function type()
    {
        return GraphQL::type('Gist');
    }

    /**
     * @return array
     */
    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'Id of the gist',
                'rules' => ['required', 'exists:gists,id']
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
        Gist::find($args['id'])->delete();

        return ['id' => $args['id']];
    }
}