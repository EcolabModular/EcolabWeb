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
     * Obtains the list of reports from the API
     * @return stdClass
     */
    public function getReports()
    {
        return $this->makeRequest('GET', 'reports');
    }

    /**
     * * Obtains a report from the API
     * @param  int $id
     * @return stdClass
     */
    public function getReport($id)
    {
        return $this->makeRequest('GET', "reports/{$id}");
    }

    /**
     * Make a report on the API
     * @param  array $reportData
     * @return sdtClass
     */
    public function makeReport($reportData)
    {
        return $this->makeRequest(
            'POST',
            "reports",
            [],
            $reportData,
            [],
            $hasFile = false
        );
    }

    /**
     * Update a report on the API
     * @param  array $reportData
     * @return sdtClass
     */
    public function updateReport($reportData)
    {
        $productData['_method'] = 'PUT';

        return $this->makeRequest(
            'POST',
            "reports",
            [],
            $reportData,
            [],
            $hasFile = false
        );
    }

    /**
     * * Delete a report from the API
     * @param  int $id
     * @return stdClass
     */
    public function deleteReport($id)
    {
        return $this->makeRequest('DELETE', "reports/{$id}");
    }

    /**
     * * Retrieve a user information from the API
     * @return stdClass
     */
    public function getUserInformation()
    {
        return $this->makeRequest('GET', "users/me");
    }

}
