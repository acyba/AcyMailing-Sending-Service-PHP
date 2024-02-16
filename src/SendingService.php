<?php

namespace AcyMailer;

require_once __DIR__.'/../vendor/autoload.php';

use AcyMailer\Routes\Domain\Add;
use AcyMailer\Routes\Domain\Delete;
use AcyMailer\Routes\Domain\Update;
use AcyMailer\Routes\GetLicenseInfo;
use AcyMailer\Routes\Send;
use AcyMailer\Services\ApiService;

class SendingService
{
    use Send;
    use GetLicenseInfo;
    use Add;
    use Delete;
    use Update;

    private string $apiKey;

    private ApiService $apiService;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->apiService = new ApiService($apiKey);
    }

    private function checkDomain(string $domain): bool
    {
        return preg_match('#[a-z0-9\-]+\.[a-z]{2,3}#', $domain) === 1;
    }
}
