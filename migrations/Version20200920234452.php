<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920234452 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql("
create table emails
(
    id               int auto_increment
        primary key,
    email            varchar(255)                        not null,
    content          longtext                            null,
    date             timestamp default CURRENT_TIMESTAMP not null,
    service          varchar(255)                        null,
    uuid             varchar(255)                        null,
    dispatch_service varchar(255)                        null,
    subject          varchar(255)                        null,
    sender_name      varchar(255)                        null,
    message          varchar(255)                        null
);
   charset = utf8mb4;
");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE emails');
    }
}
