<?php

namespace AcyMailer\Routes\Domain;

use Exception;

trait Add
{
    /**
     * @param string $domain  The domain to add, can't be a subdomain
     * @param string $siteUrl The site URL to attach to the domain, default is https://<domain-added.com>
     *
     * @return array
     * @throws Exception
     */
    public function addDomain(string $domain, string $siteUrl = ''): array
    {
        if (!$this->checkDomain($domain)) {
            throw new Exception('The domain provided is not valid.');
        }

        if (empty($siteUrl)) {
            $siteUrl = 'https://'.$domain;
        }

        $requestOptions = [
            'method' => 'POST',
            'body' => [
                'domain' => $domain,
                'siteUrl' => $siteUrl,
            ],
        ];

        return $this->apiService->request('/api/createDomainIdentity', $requestOptions);
    }
}
