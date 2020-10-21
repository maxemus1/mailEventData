<?php

namespace App\Services\ProcessingEmail\CheckEmailServices;

use DI\Container;
use PDO;

class CheckBlackList implements CheckEmailInterface
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
        $query = "SELECT * FROM black_email WHERE email =:email";
        $stmt =  $this->dataBaseConnection ->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->fetch()) {

            return "Error email data is black list!";
        }

        return "ok";
    }
}
