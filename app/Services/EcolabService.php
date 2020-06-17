<?php

namespace App\Services;

use App\Traits\AuthorizesEcolabRequests;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithEcolabResponses;

class EcolabService
{
    use ConsumesExternalServices, AuthorizesEcolabRequests, InteractsWithEcolabResponses;

    /**
     * The url from which send the requests
     * @var string
     */
    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.ecolab.base_uri');
    }

    /**
     * * Obtains all records from the API
     * @param  int $id
     * @return stdClass
     */
    public function getAll($url,$query = [])
    {
        return $this->makeRequest('GET', $url, $query);
    }

    /**
     * * Obtains a record from the API
     * @param  int $id
     * @param  string $url
     * @return stdClass
     */
    public function getOne($url,$id)
    {
        return $this->makeRequest('GET', "{$url}/{$id}");
    }

    /**
     * Make a record on the API
     * @param  array $data
     * @return sdtClass
     */
    public function create($url, $data, $hasFile)
    {
        return $this->makeRequest(
            'POST',
            $url,
            [],
            $data,
            [],
            $hasFile
        );
    }

    /**
     * Update a record on the API
     * @param  array $data
     * @return sdtClass
     */
    public function update($url,$data,$hasFile)
    {
        $data['_method'] = 'PUT';

        return $this->makeRequest(
            'POST',
            $url,
            [],
            $data,
            [],
            $hasFile
        );
    }

    /**
     * * Delete a record from the API
     * @param  int $id
     * @return stdClass
     */
    public function delete($url,$id)
    {
        return $this->makeRequest("DELETE", $url."/{$id}");
    }

    /**
     * * Retrieve a user information from the API
     * @return stdClass
     */
    public function getUserInformation()
    {
        return $this->makeRequest('GET', "info");
    }

}
