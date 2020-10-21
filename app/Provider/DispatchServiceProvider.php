<?php

namespace App\Provider;

use App\Services\DispatchService\MailganerService;
use App\Services\DispatchService\MailgunService;
use App\Services\DispatchService\LeaderSendServices;

class DispatchServiceProvider
{
    /**
     * @var array
     */
    private array $array = [];

    /**
     * DispatchServiceProvider constructor.
     */
    public function __construct()
    {
        $this->array['mailgun'] = function () {
            return MailgunService::class;
        };
        $this->array['smtp'] = function () {
            return MailganerService::class;
        };
        $this->array['leadersend'] = function () {
            return LeaderSendServices::class;
        };
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->array;
    }
}
