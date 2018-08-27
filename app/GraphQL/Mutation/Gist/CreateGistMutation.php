<?php

namespace App\GraphQL\Mutation\Gist;

use App\GraphQL\Serializer\FolderSerializer;
use App\GraphQL\Serializer\GistSerializer;
use App\Models\Gist;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class CreateGistMutation extends Mutation
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'createGist',
        'description' => 'Create a new gist'
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
            'gist' => [
                'type' => Type::string(),
                'description' => 'Id from gist.github',
                'rules' => ['required', 'max:32', 'min:32', 'unique:gists,gist_id']
            ],
            'folder' => [
                'type' => Type::id(),
                'description' => 'Folder for the gist',
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
            'gist_id' => $args['gist'],
            'folder_id' => isset($args['folder']) ? $args['folder'] : null,
            'user_id' => 5,
        ];

        $gist = Gist::create($createData);

        return GistSerializer::getInstance()->serialize($gist);
    }
}