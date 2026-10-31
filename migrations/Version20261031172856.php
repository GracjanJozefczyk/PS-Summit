<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261031172856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add brand relation to product variant';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product_variant ADD brand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product_variant ADD CONSTRAINT FK_A29B52344F5D008 FOREIGN KEY (brand_id) REFERENCES app_brand (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_A29B52344F5D008 ON sylius_product_variant (brand_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product_variant DROP FOREIGN KEY FK_A29B52344F5D008');
        $this->addSql('DROP INDEX IDX_A29B52344F5D008 ON sylius_product_variant');
        $this->addSql('ALTER TABLE sylius_product_variant DROP brand_id');
    }
}
