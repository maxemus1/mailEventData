<?php

namespace App\Services\AssistantsServices;

use App\Services\AssistantsServices\UUIDGeneration;
use DI\Container;

class RequestBuilder
{
    /**
     * @var \App\Services\AssistantsServices\UUIDGeneration
     */
    protected UUIDGeneration $generation;
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * RequestBuilder constructor.
     * @param \App\Services\AssistantsServices\UUIDGeneration $generation
     * @param Container $container
     */
    public function __construct(UUIDGeneration $generation, Container $container)
    {
        $this->generation = $generation;
        $this->container = $container;
    }

    /**
     * @return object
     */
    protected function getRequestObject()
    {
        header('content-type: application/json');

        return json_decode(file_get_contents('php://input'));
    }

    /**
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function builderDataRequest()
    {
        $defaultSetting = $this->container->get('defaultSetting') ?? [];

        $request = $this->getRequestObject();

        $data['uuid'] = $this->generation->get();
        $data['service'] = strtoupper($request->service) ?: $defaultSetting['defaultService'];
        $data['subject'] = $request->EmailSubject ?: null;
        $data['content'] = $request->EmailContent ?: null;
        $data['sender_name'] = $request->EmailSenderName ?: 'Robot';
        $data['email'] = $request->Email ?: null;

        return $data;
    }
}
