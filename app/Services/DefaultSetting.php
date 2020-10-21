<?php

namespace App\Services;

use App\Model\DispatchServices;
use DI\Container;

class DefaultSetting
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * @var DispatchServices
     */
    private DispatchServices $dispatchServices;


    /**
     * DefaultSetting constructor.
     * @param DispatchServices $dispatchServices
     * @param Container $container
     */
    public function __construct(DispatchServices $dispatchServices, Container $container)
    {
        $this->dispatchServices = $dispatchServices;
        $this->container = $container;
    }

    /**
     * @param $service
     * @return array
     */
    public function defaultDispatchServices($service): array
    {
        $defaultSetting = $this->container->get('defaultSetting') ?? [];

        $serviceSend['service'] = $defaultSetting['defaultService'];
        $serviceSend['domain'] = $defaultSetting['defaultDomain'];

        $dataDispatchServices = $this->dispatchServices->getService($service);

        if (!empty($dataDispatchServices)) {
            $serviceSend['service'] = $dataDispatchServices['service'];
            $serviceSend['domain'] = $dataDispatchServices['domain'];
        }

        return $serviceSend;
    }
}
