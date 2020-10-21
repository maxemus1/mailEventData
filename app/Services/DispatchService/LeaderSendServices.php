<?php

namespace App\Services\DispatchService;

use App\Services\DispatchService\leadersend\inc\Leadersend;
use DI\Container;

class LeaderSendServices implements DispatchInterface
{
    const ERRORS = [
        '30' => 'Invalid email address.',
        '31' => 'Specified email address looks fake or is invalid. You must provide a real email address.',
        '34' => 'Request size for the API call is to big - more detail in the actual message returned.',
        '36' => 'You must specify an authenticated sending domain (read more information here).',
        '37' => 'No authentication - unknown sending domain (read more information here).',
        '38' => 'Maximum bulk email recipients limit reached. Please contact support.',
        '103' => 'The account being accessed has no active plan.',
        '104' => 'You have reached sending limit per day.',
        '105' => 'Provided API key is invalid.',
        '106' => 'Non-verified client reached daily sending limit.',
        '107' => 'Waiting for account verification.',
        '108' => 'There are no email credits in the account.',
        '109' => 'Hourly sending limit has been reached. Please wait until next hour or upgrade your account.',
        '10' => 'You must specify value for the parameter reported in actual error message.',
        '11' => 'Invalid parameter type.',
        '12' => 'Parameter reported in actual message is required.',
        '-1' => 'System temporary is unavailable.',
        '-2' => 'Requested API method is not supported.',
        '-3' => 'Unknown error.',
        '-98' => 'We are running system maintenance.'
    ];

    /**
     * @var Container
     */
    protected Container $container;

    /**
     * LeaderSendServices constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $domain
     * @param array $request
     * @return string
     */
    public function sending(string $domain, array $request)
    {
        $configApi = $this->container->get('api') ?? [];

        $leaderSend = new Leadersend($configApi['leaderSend']['key']);

        $params = array(
            'to' => array(array('email' => $request['email'])),
            'html' => $request['content'],
            'auto_plain' => true,
            'subject' => $request['subject'],
            'from' => array(
                'email' => $domain,
                'name' => $request['sender_name'],
            ),
            'signing_domain' => substr(stristr($domain, '@'), 1),
            'tracking' => array(
                'opens' => true,
                'html_clicks' => false,
                'plain_clicks' => false,
                'domain' => substr(stristr($domain, '@'), 1)
            )
        );

        $leaderSend->messagesSend($params);

        if ($leaderSend->errorCode) {

            return "Error: " . self::ERRORS[(string)$leaderSend->errorCode];
        }

        return "ok";
    }
}
