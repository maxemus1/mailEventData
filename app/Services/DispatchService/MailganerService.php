<?php

namespace App\Services\DispatchService;

use DI\Container;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailganerService implements DispatchInterface
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * MailganerService constructor.
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
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function sending(string $domain, array $request)
    {
        $configApi = $this->container->get('api') ?? [];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailganer.com:1126';
            $mail->SMTPAuth = true;
            $mail->Username = $configApi['mailganer']['login'];
            $mail->Password = $configApi['mailganer']['key'];;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 1126;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($domain, $request['sender_name']);
            $mail->addAddress($request['email']);
            $mail->addCustomHeader('List-Unsubscribe,', 'wb.test.ru');
            $mail->addCustomHeader('X-Track-ID', 'wb.test.ru');
            $mail->addCustomHeader('X-Postmaster-Msgtype', 'wb.test.ru');

            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);
            $mail->Subject = $request['subject'];
            $mail->Body = $request['content'];

            $mail->send();

            return "ok";

        } catch (Exception $e) {

            return "{$mail->ErrorInfo}";
        }
    }
}
