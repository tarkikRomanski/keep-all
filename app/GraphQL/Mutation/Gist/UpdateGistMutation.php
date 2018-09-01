<?php

namespace App\GraphQL\Mutation\Gist;

use App\GraphQL\Serializer\GistSerializer;
use App\Models\Gist;
use App\Repositories\GistRepository;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Folklore\GraphQL\Support\Mutation;

class UpdateGistMutation extends Mutation
{
    /**
     * @var GistRepository|null
     */
    private $gistRepository = null;

    /**
     * UpdateGistMutation constructor.
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
            'gist' => [
                'type' => Type::string(),
                'description' => 'The id of the gist',
                'rules' => ['required']
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The new description for the gist',
                'rules' => ['min:3']
            ],
            'files' => [
                'type' => Type::listOf(GraphQL::type('File')),
                'description' => 'The new files of the gist'
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
     * @return array
     */
    public function resolve($root, $args)
    {
        $updateData = $this->prepareData($args);

        $updatedGist = [];

        if (isset($args['folder'])) {
            $updatedGist = $this->gistRepository->changeFolderForGist($args['gist'], $args['folder']);
        }

        if (!empty($updateData)) {
            $updatedGist = $this->gistRepository->updateGist($args['gist'], $updateData);
        }

        return GistSerializer::getInstance()->serialize($updatedGist);
    }

    /**
     * Prepare data for update
     *
     * @param $args
     * @return array
     */
    private function prepareData($args)
    {
        $returnData = [];

        if (isset($args['description'])) {
            $returnData['description'] = $args['description'];
        }

        if (isset($args['files'])) {
            foreach ($args['files'] as $file) {
                $returnData['files'][$file['name']] = [
                    'content' => $file['content']
                ];
            }
        }

        return $returnData;
    }
}