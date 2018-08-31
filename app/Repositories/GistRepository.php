<?php

namespace App\Repositories;

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

    /**
     * Get all gists by API
     *
     * @return mixed
     */
    public function getGists()
    {
        $url = 'users/tarkikRomanski/gists?access_token=390a6aa20139aa696ba9ff546b784e04eec10be2';

        $gistsResponse = $this->client->get($url);
        $gistsList = json_decode($gistsResponse->getBody());

        return $gistsList;
    }
}