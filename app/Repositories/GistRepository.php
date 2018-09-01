<?php

namespace App\Repositories;

use App\Models\Gist;
use GuzzleHttp\Client;


class GistRepository
{
    /**
     * @var Client|null
     */
    private $client = null;

    /**
     * @var array
     */
    private $headers = [
        'Content-Type' => 'application/json'
    ];

    /**
     * @var string
     */
    private $gistApiToken = '4a218923e76bb7f87bf97d5da09ef70c199d8022';

    /**
     * GistRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->headers['Authorization'] = 'token ' . $this->gistApiToken;
    }

    /**
     * Get all gists by API
     *
     * @return array
     */
    public function getGists() : array
    {
        $url = 'users/tarkikRomanski/gists?access_token=' . $this->gistApiToken;

        $gistsResponse = $this->client->get($url);
        $gistsList = json_decode($gistsResponse->getBody());

        return $gistsList;
    }

    /**
     * Get a single gist
     *
     * @param string $gistId
     * @return object
     */
    public function getGist(string $gistId) : object
    {
        $url = 'gists/' . $gistId;

        $singleResponse = $this->client->get($url, [
            'headers' => $this->headers
        ]);

        $gist = json_decode($singleResponse->getBody()->getContents());

        return $this->margeGistWithLocalData($gist);
    }

    /**
     * Create a new gist
     *
     * @param array $gist
     * @return object
     */
    public function createGist(array $gist) : object
    {
        $url = 'gists';

        $body = json_encode($gist);

        $createResponse = $this->client->post($url, [
            'headers' => $this->headers,
            'body' => $body
        ]);

        $createdGist = json_decode($createResponse->getBody()->getContents());

        if (is_null($gist['folder'])) {
            return $this->margeGistWithLocalData($createdGist);
        }

        $localGist = $this->addFolderForGist($createdGist->id, $gist['folder']);

        return $this->margeGistWithLocalData($createdGist, $localGist);
    }

    /**
     * @param string $gistId
     * @param array $data
     *
     * @return object
     */
    public function updateGist(string $gistId, array $data) : object
    {
        $url = 'gists/' . $gistId;

        $body = json_encode($data);

        $updateResponse = $this->client->patch($url, [
            'headers' => $this->headers,
            'body' => $body
        ]);

        $updatedGist = json_decode($updateResponse->getBody()->getContents());

        return $this->margeGistWithLocalData($updatedGist);
    }

    /**
     * Change the folder for the gist
     *
     * @param string $gistId
     * @param int $folderId
     * @return object
     */
    public function changeFolderForGist(string $gistId, int $folderId) : object
    {
        $gist = $this->getGist($gistId);

        if (!Gist::where('gist_id', $gist->id)->exists()) {
            $localGist = $this->addFolderForGist($gistId, $folderId);
            return $this->margeGistWithLocalData($gist, $localGist);
        }

        $localGist = Gist::where('gist_id', $gistId)->first();
        $localGist->update(['folder_id' => $folderId]);

        return $this->margeGistWithLocalData($gist, $localGist);
    }

    /**
     * Delete the gist by id
     *
     * @param string $gistId
     * @return bool
     */
    public function deleteGist(string $gistId) : bool
    {
        Gist::where('gist_id', $gistId)->delete();

        $url = 'gists/' . $gistId;

        $this->client->delete($url, [
            'headers' => $this->headers,
        ]);

        return true;
    }

    /**
     * Add folder for the gist
     *
     * @param string $gistId
     * @param int $folderId
     * @return Gist
     */
    private function addFolderForGist(string $gistId, int $folderId) : Gist
    {
        $gist = Gist::create([
            'gist_id' => $gistId,
            'folder_id' => $folderId,
            'user_id' => 5
        ]);

        return $gist;
    }

    /**
     * Marge api gist data with local record
     *
     * @param object $gist
     * @param Gist|null $localGist
     * @return object
     */
    private function margeGistWithLocalData(object $gist, ?Gist $localGist = null) : object
    {
        if (is_null($localGist) && !Gist::where('gist_id', $gist->id)->exists()) {
            $gist->folder =
            $gist->local_id =
            $gist->local_user = null;

            return $gist;
        }

        $localGist = $localGist ?? Gist::where('gist_id', $gist->id)->first();

        $gist->folder = $localGist->folder()->getResults();
        $gist->local_id = $localGist->id;
        $gist->local_user = $localGist->user_id;

        return $gist;
    }
}