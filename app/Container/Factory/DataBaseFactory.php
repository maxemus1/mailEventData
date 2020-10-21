<?php


namespace App\Container\Factory;

use DI\Container;
use PDO;
use PDOException;

class DataBaseFactory
{
    /**
     * @var Container
     */
    protected Container $container;

    /**
     * DataBaseFactory constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return PDO|string
     */
    public function create()
    {
        $config = $this->container->get('db') ?? [];

        $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port'] . ';dbname=' . $config['name'];

        try {
            $connection = new PDO($dsn, $config['username'], $config['password']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $e) {

            return 'Подключение не удалось: ' . $e->getMessage();
        }
    }
}
