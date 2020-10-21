<?php

namespace App\Services\DelayedQueue;

use App\Model\DispatchServices;

class CheckMailingService
{
    /**
     * @var DispatchServices
     */
    private DispatchServices $dispatchServices;

    public function __construct(DispatchServices $dispatchServices)
    {
        $this->dispatchServices = $dispatchServices;
    }

    /**
     * @param string $service
     * @param int $status
     * @return bool
     */
    public function check(string $service, int $status)
    {
        $dataDispatchServices = $this->dispatchServices->getService($service);

        if (empty($dataDispatchServices)) {
            return false;
        }

        if ($dataDispatchServices['status'] == $status) {

            return false;
        }

        return true;
    }
}
