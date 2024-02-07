<?php

namespace AcyMailer\Routes;

use Exception;

trait GetCredits
{
    /**
     * @throws Exception
     */
    public function getCredits(): array
    {
        return $this->apiService->request('/api/get_credits');
    }
}
