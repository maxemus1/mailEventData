<?php

namespace App\Services;

use App\Model\Email;
use App\Services\ProcessingEmail\CheckServices;
use App\Services\DispatchService\DispatchInterface;
use DI\Container;

class SendingService
{
    const OK = 'ok';

    private Container $container;
    private CheckServices $checkServices;
    private Email $email;
    private DefaultSetting $defaultSetting;

    public function __construct(Container $container, CheckServices $checkServices, Email $email, DefaultSetting $defaultSetting)
    {
        $this->container = $container;
        $this->checkServices = $checkServices;
        $this->email = $email;
        $this->defaultSetting = $defaultSetting;
    }

    /**
     * @param array $request
     * @return string|null
     */
    protected function checkRequest(array $request)
    {
        $message = null;

        if (empty($request['email'])) {
            $message = "Error email(hash) is null!";
        }

        if (empty($request['subject'])) {
            $message = "Error subject is null!";
        }

        if (empty($request['content'])) {
            $message = "Error content is null!";
        }

        return $message;
    }

    /**
     * @param array $request
     */
    public function sending(array $request)
    {
        $serviceClass = $this->container->get(DispatchInterface::class);

        $dispatchService = null;
        $message = null;
        $message = $this->checkRequest($request);

        if (is_null($message)) {
            $message = $this->checkServices->check($request['email']);
            if ($message == self::OK) {
                $serviceSend = $this->defaultSetting->defaultDispatchServices($request['service']);
                $request['dispatch_service'] = $serviceSend['service'];
                $serviceClass = $this->container->get($serviceClass[$serviceSend['service']]());
                $serviceClass->sending($serviceSend['domain'], $request);
            }
        }

        $this->email->saveEmail($request, $message);
    }
}
