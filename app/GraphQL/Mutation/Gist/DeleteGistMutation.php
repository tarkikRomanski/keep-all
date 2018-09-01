<?php

namespace App\GraphQL\Mutation\Gist;

use App\Models\Gist;
use App\Repositories\GistRepository;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class DeleteGistMutation extends Mutation
{
    /**
     * @var GistRepository|null
     */
    private $gistRepository = null;

    /**
     * DeleteGistMutation constructor.
     * @param GistRepository $gistRepository
     * @param array $attributes
     */
    public function __construct(GistRepository $gistRepository, $attributes = [])
    {
        $this->gistRepository = $gistRepository;
        parent::__construct($attributes);
    }

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
            'gist' => [
                'type' => Type::nonNull(Type::id()),
                'description' => 'Id of the gist',
                'rules' => ['required']
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
        $this->gistRepository->deleteGist($args['gist']);

        return ['gist' => $args['gist']];
    }
}