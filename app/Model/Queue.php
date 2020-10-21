<?php

namespace App\Model;

use DI\Container;
use PDO;

class Queue
{
    /**
     * @var mixed|PDO
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
     * @return array
     */
    public function store(array $data)
    {
        $queryDataEmail = "INSERT INTO queues SET uuid=:uuid, service=:service ,email=:email ,subject=:subject, content=:content, sender_name=:sender_name";

        $stmt = $this->dataBaseConnection->prepare($queryDataEmail);

        $stmt->bindValue(':uuid', $data['uuid']);
        $stmt->bindValue(':service', $data['service']);
        $stmt->bindValue(':subject', $data['subject']);
        $stmt->bindValue(':content', $data['content']);
        $stmt->bindValue(':sender_name', $data['sender_name']);
        $stmt->bindValue(':email', $data['email']);

        $stmt->execute();

        return $data;
    }

    /**
     * @return mixed
     */
    public function getOneEntry()
    {
        $query = "SELECT * FROM queues LIMIT 1";
        $resultQueryHash = $this->dataBaseConnection->prepare($query);
        $resultQueryHash->execute();

        return $resultQueryHash->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $query = "DELETE FROM queues WHERE id=:id";
        $stmt = $this->dataBaseConnection->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
