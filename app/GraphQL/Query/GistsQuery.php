<?php

namespace App\GraphQL\Query;

use App\GraphQL\Serializer\GistSerializer;
use App\Models\Gist;
use App\Repositories\GistRepository;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Query;

class GistsQuery extends Query
{
    /**
     * @var GistRepository|null
     */
    private $gistRepository = null;

    /**
     * GistsQuery constructor.
     * @param array $attributes
     * @param GistRepository $gistRepository
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
     * @return array
     */
    public function resolve($root, $args)
    {
        $gistsList = $this->gistRepository->getGists();

        return array_map(function ($gist) {
            $localGist = Gist::where('gist_id', $gist->id)->first();
            if ($localGist) {
                $gist->local_id = $localGist->id;
                $gist->local_user = $localGist->user_id;
                $gist->folder = $localGist->folder()->getResults();
            }
            return GistSerializer::getInstance()->serialize($gist);
        }, $gistsList);

        // $alias = [
        //     'gist' => 'gist_id',
        //     'folder' => 'folder_id',
        // ];
        // $args = transformFields($args, $alias);
    }
}