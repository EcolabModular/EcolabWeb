<?php

namespace App\Traits;

use App\Services\EcolabAuthenticationService;

trait AuthorizesEcolabRequests
{
    /**
     * Resolves the elements to send when authorazing the request
     * @param  array &$queryParams
     * @param  array &$formParams
     * @param  array &$headers
     * @return void
     */
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
    }

    public function resolveAccessToken()
    {
        $authenticationService = resolve(EcolabAuthenticationService::class);

        if (auth()->user()) {
            return $authenticationService->getAuthenticatedUserToken();
        }

        return $authenticationService->getClientCredentialsToken();
    }
}
