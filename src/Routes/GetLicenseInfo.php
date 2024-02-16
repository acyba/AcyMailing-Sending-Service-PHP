<?php

namespace AcyMailer\Routes;

use Exception;

trait GetLicenseInfo
{
    /**
     * @throws Exception
     */
    public function getLicenseInfo(): array
    {
        return $this->apiService->request('/api/get_credits');
    }
}
