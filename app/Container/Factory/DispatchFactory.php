<?php

namespace App\Container\Factory;

use App\Provider\DispatchServiceProvider;

class DispatchFactory
{
    /**
     * @var DispatchServiceProvider
     */
    private DispatchServiceProvider $serviceDispatch;

    /**
     * DispatchFactory constructor.
     * @param DispatchServiceProvider $senderArray
     */
    public function __construct(DispatchServiceProvider $senderArray)
    {
        $this->serviceDispatch = $senderArray;
    }

    /**
     * @return array
     */
    public function create()
    {
        return $this->serviceDispatch->get();
    }
}
