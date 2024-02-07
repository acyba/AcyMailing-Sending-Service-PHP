<?php

namespace AcyMailer\Routes\Domain;

use Exception;

trait Delete
{
    /**
     * @param string $domain
     * @param string $siteUrl
     *
     * @return void
     * @throws Exception
     */
    public function deleteDomain(string $domain, string $siteUrl = ''): void
    {
        if (!$this->checkDomain($domain)) {
            throw new Exception('The domain provided is not valid.');
        }

        if (empty($siteUrl)) {
            $siteUrl = 'https://'.$domain;
        }

        $requestOptions = [
            'method' => 'DELETE',
            'body' => [
                'domain' => $domain,
                'siteUrl' => $siteUrl,
            ],
        ];

        $this->apiService->request('/api/deleteDomainIdentity', $requestOptions);
    }
}
