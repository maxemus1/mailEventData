<?php

namespace App\Controllers;

use App\Services\AssistantsServices\RequestBuilder;
use App\Model\Queue;

class EventDataController
{
    /**
     * @var Queue
     */
    private Queue $queue;

    /**
     * @var RequestBuilder
     */
    private RequestBuilder $request;

    /**
     * EventDataController constructor.
     * @param Queue $queue
     * @param RequestBuilder $requestBuilder
     */
    public function __construct(Queue $queue, RequestBuilder $requestBuilder)
    {
        $this->queue = $queue;
        $this->request = $requestBuilder;
    }

    public function addQueue()
    {
        $request = $this->request->builderDataRequest();

        $data = $this->queue->store($request);

        echo json_encode(["uuid" => $data['uuid']]);
    }
}
