<?php

namespace App\Model;

use DI\Container;
use PDO;

class DispatchServices
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
     * @param string $service
     * @return mixed
     */
    public function getService(string $service)
    {
        $query = "SELECT * FROM dispatch_services WHERE service=:service";
        $result = $this->dataBaseConnection->prepare($query);
        $result->bindValue(':service', $service);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }
}
