<?php

namespace App\Repositories;

use App\Models\Gist;
use GuzzleHttp\Client;


class GistRepository
{
    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * GistRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private $gistApiToken = '4a218923e76bb7f87bf97d5da09ef70c199d8022';

    /**
     * Get all gists by API
     *
     * @return array
     */
    public function getGists()
    {
        $url = 'users/tarkikRomanski/gists?access_token=' . $this->gistApiToken;

        $gistsResponse = $this->client->get($url);
        $gistsList = json_decode($gistsResponse->getBody());

        return $gistsList;
    }

    /**
     * Create a new gist
     *
     * @param array $gist
     * @return object
     */
    public function createGist(array $gist)
    {
        $url = 'gists';

        $headers = [
            'Authorization' => 'token ' . $this->gistApiToken,
            'Content-Type' => 'application/json'
        ];

        $body = json_encode($gist);

        $createResponse = $this->client->post($url, [
            'headers' => $headers,
            'body' => $body
        ]);

        $createdGist = json_decode($createResponse->getBody()->getContents());

        if (is_null($gist['folder'])) {
            return $createdGist;
        }

        $localGist = $this->addFolderForGist($createdGist->id, $gist['folder']);

        $createdGist->folder = $localGist->folder()->getResults();
        $createdGist->local_id = $localGist->id;
        $createdGist->local_user = $localGist->user_id;

        return $createdGist;
    }

    /**
     * Add folder for the gist
     *
     * @param string $gist_id
     * @param int $folder_id
     * @return Gist
     */
    private function addFolderForGist(string $gist_id, int $folder_id) : Gist
    {
        $gist = Gist::create([
            'gist_id' => $gist_id,
            'folder_id' => $folder_id,
            'user_id' => 5
        ]);

        return $gist;
    }
}