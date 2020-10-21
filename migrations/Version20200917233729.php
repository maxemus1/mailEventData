<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917233729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
create table black_email
(
    id          int auto_increment primary key,
    email       varchar(255)                        not null,
    description text                                null,
    create_date timestamp default CURRENT_TIMESTAMP not null
)
   charset = utf8mb4;
");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE black_email');
    }
}
