<?php

namespace App\Model;

use DI\Container;
use PDO;

class DelayedQueue
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
     * @param array $data
     */
    public function toDelayedQueue(array $data)
    {
        $queryDataEmail = "INSERT INTO delayed_queue SET uuid=:uuid, service=:service ,email=:email ,subject=:subject, content=:content, sender_name=:sender_name";
        $stmt = $this->dataBaseConnection->prepare($queryDataEmail);

        $stmt->bindValue(':uuid', $data['uuid']);
        $stmt->bindValue(':service', $data['service']);
        $stmt->bindValue(':subject', $data['subject']);
        $stmt->bindValue(':content', $data['content']);
        $stmt->bindValue(':sender_name', $data['sender_name']);
        $stmt->bindValue(':email', $data['email']);

        $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getOneEntry()
    {
        $query = "SELECT * FROM delayed_queue LIMIT 1";
        $resultQueryHash = $this->dataBaseConnection->prepare($query);
        $resultQueryHash->execute();

        return $resultQueryHash->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $query = "DELETE FROM delayed_queue WHERE id=:id";
        $stmt = $this->dataBaseConnection->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
