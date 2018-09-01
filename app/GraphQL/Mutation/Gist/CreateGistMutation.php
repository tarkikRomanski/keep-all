<?php

namespace App\GraphQL\Mutation\Gist;

use App\GraphQL\Serializer\GistSerializer;
use App\Repositories\GistRepository;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class CreateGistMutation extends Mutation
{
    /**
     * @var GistRepository|null
     */
    private $gistRepository = null;

    /**
     * CreateGistMutation constructor.
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
            'description' => [
                'type' => Type::string(),
                'description' => 'Description for a new gist',
                'rules' => ['required', 'min:3']
            ],

            'files' => [
                'type' => Type::listOf(GraphQL::type('File')),
                'description' => 'The files of a new gist',
                'rules' => ['required']
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
            'description' => $args['description'],
            'public' => true,
            'files' => [],
            'folder' => isset($args['folder']) ? $args['folder'] : null
        ];

        foreach ($args['files'] as $file) {
            $createData['files'][$file['name']] = [
                'content' => $file['content']
            ];
        }

        $gist = $this->gistRepository->createGist($createData);

        return GistSerializer::getInstance()->serialize($gist);
    }
}