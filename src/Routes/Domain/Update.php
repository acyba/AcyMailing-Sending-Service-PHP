<?php

namespace AcyMailer\Routes\Domain;

use Exception;

trait Update
{
    /**
     * @param int  $domainId
     * @param bool $isLimited
     * @param int  $creditsAllowed
     *
     * @return void
     * @throws Exception
     */
    public function updateDomain(int $domainId, bool $isLimited, int $creditsAllowed): void
    {
        if (empty($domainId) || $domainId < 1) {
            throw new Exception('The domain ID provided is not valid.');
        }

        if ($creditsAllowed < 0) {
            throw new Exception('The credits allowed must be a positive number.');
        }

        $requestOptions = [
            'method' => 'PATCH',
            'body' => [
                'isLimited' => $isLimited,
                'creditsAllowed' => $creditsAllowed,
            ],
        ];

        $this->apiService->request('/api/domains/'.$domainId, $requestOptions);
    }
}
