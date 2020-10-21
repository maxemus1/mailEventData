<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920234225 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
create table dispatch_services
(
    id          int auto_increment  primary key,
    domain      varchar(255)  not null,
    service     varchar(255)  not null,
    status int default 1 null
);
   charset = utf8mb4;
");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE dispatch_services');
    }
}
