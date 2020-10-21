<?php

namespace App\Model;

use DI\Container;
use PDO;

class Email
{
    /**
     * @var Container|mixed|PDO
     */
    protected PDO $dataBaseConnection;

    /**
     * Queue constructor.
     * @param Container $container
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->dataBaseConnection = $container->get(PDO::class);
    }

    /**
     * @param array $request
     * @param string $message
     */
    public function saveEmail(array $request, string $message)
    {
        $queryDataEmail = "INSERT INTO emails SET uuid=:uuid, service=:service, subject=:subject, content=:content, sender_name=:sender_name, email=:email, dispatch_service=:dispatch_service, message=:message";
        $stmt = $this->dataBaseConnection->prepare($queryDataEmail);

        $stmt->bindValue(':uuid', $request['uuid']);
        $stmt->bindValue(':service', $request['service']);
        $stmt->bindValue(':subject', $request['subject']);
        $stmt->bindValue(':content', $request['content']);
        $stmt->bindValue(':sender_name', $request['sender_name']);
        $stmt->bindValue(':email', $request['email']);
        $stmt->bindValue(':dispatch_service', $request['dispatch_service']);
        $stmt->bindValue(':message', $message);

        $stmt->execute();
    }
}
