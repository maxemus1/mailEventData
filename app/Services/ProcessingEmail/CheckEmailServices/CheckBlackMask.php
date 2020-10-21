<?php

namespace App\Services\ProcessingEmail\CheckEmailServices;

use DI\Container;
use PDO;

class CheckBlackMask implements CheckEmailInterface
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
     * @param string $email
     * @return string
     */
    public function check(string $email)
    {
        $query = "SELECT * FROM mask_black_list";
        $stmt = $this->dataBaseConnection->prepare($query);
        $stmt->execute();
        $mask = $stmt->fetchAll();

        foreach ($mask as $key => $value) {
            if (preg_match("/$value[mask]/", $email)) {
                return "Error email mask black list!";
            }
        }

        return "ok";
    }
}
