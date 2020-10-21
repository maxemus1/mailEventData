<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200920234550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
create table mask_black_list
(
    id   int auto_increment
        primary key,
    mask varchar(255) not null
);
   charset = utf8mb4;
");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE mask_black_list');
    }
}
