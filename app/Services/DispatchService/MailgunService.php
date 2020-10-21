<?php

namespace App\Services\DispatchService;

use DI\Container;
use Mailgun\Mailgun;
use Mailgun\Exception;

class MailgunService implements DispatchInterface
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * MailgunService constructor.
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

        $mgClient = new Mailgun($configApi['mailgun']['key']);

        try {
            $param = array(
                'from' => $request['sender_name'] . ' ' . $domain,
                'to' => $request['email'],
                'subject' => $request['subject'],
                'html' => $request['content'],
            );
            $mgClient->sendMessage(substr(stristr($domain, '@'), 1), $param);
        } catch (Exception $e) {

            return "Error: " . $e->getMessage();
        }

        return "ok";
    }
}
