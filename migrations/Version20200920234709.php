<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920234709 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("
create table queues
(
    id             int auto_increment
        primary key,
    uuid           varchar(255)  null,
    subject        varchar(255)  null,
    email           varchar(255)  null,
    content        longtext      null,
    sender_name    varchar(255)  null,
    service        varchar(255)  null
);
   charset = utf8mb4;
");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE queues');
    }
}
