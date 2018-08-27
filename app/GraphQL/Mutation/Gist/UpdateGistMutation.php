<?php

namespace App\GraphQL\Mutation\Gist;

use App\GraphQL\Serializer\GistSerializer;
use App\Models\Gist;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class UpdateGistMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'updateGist',
        'description' => 'Update the gist'
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
                'type' => Type::id(),
                'description' => 'Id of the gist',
                'rules' => ['required', 'exists:gists,id']
            ],
            'gist' => [
                'type' => Type::string(),
                'description' => 'Id from gist.github',
                'rules' => ['max:32', 'min:32', 'unique:gists,gist_id']
            ],
            'folder' => [
                'type' => Type::id(),
                'description' => 'Folder for the gist',
                'rules' => ['numeric', 'exists:folders,id', 'nullable']
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
        $gist = Gist::find($args['id']);

        $alias = [
            'gist' => 'gist_id',
            'folder' => 'folder_id',
        ];
        $updateData = $this->transformFields($args, $alias);

        $gist->update($updateData);

        return GistSerializer::getInstance()->serialize($gist);
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
        /* TODO create helper for this method or add method to a class */
        return array_column(array_map(function ($key, $value) use ($alias) {
            $key = isset($alias[$key]) ? $alias[$key] : $key;
            return [$key, $value];
        }, array_keys($args), $args), 1, 0);
    }
}