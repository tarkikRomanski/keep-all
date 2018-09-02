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
            'folder' => [
                'type' => Type::id(),
                'description' => 'Folder for the gist',
                'rules' => ['numeric', 'exists:folders,id']
            ],
            'withoutFolder' => [
                'type' => Type::boolean(),
                'description' => 'Show gists without folder',
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

        if (isset($args['withoutFolder']) && $args['withoutFolder'] == true && !isset($args['folder'])) {
            $gistsList = array_filter($gistsList, function($gist) {
                return is_null($gist->folder);
            });
        }

        if (isset($args['folder'])) {
            $gistsList = array_filter($gistsList, function($gist) use ($args) {
                return $gist->folder !== null && $gist->folder->id == $args['folder'];
            });
        }

        return GistSerializer::getInstance()->collection($gistsList);
    }
}