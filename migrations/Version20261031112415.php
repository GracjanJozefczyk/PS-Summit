<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261031112415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Brand entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE app_brand (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT NOT NULL, UNIQUE INDEX UNIQ_CA81749577153098 (code), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE app_brand');
    }
}
