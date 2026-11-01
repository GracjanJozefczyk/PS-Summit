<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20261101082731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add images and translation for brands';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE app_brand_channels (brand_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_EBDEE35944F5D008 (brand_id), INDEX IDX_EBDEE35972F5A1AA (channel_id), PRIMARY KEY (brand_id, channel_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE app_brand_image (type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, INDEX IDX_C721EBF47E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE app_brand_translation (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, translatable_id INT NOT NULL, INDEX IDX_747DC8052C2AC5D3 (translatable_id), UNIQUE INDEX app_brand_translation_uniq_trans (translatable_id, locale), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE app_brand_channels ADD CONSTRAINT FK_EBDEE35944F5D008 FOREIGN KEY (brand_id) REFERENCES app_brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_brand_channels ADD CONSTRAINT FK_EBDEE35972F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_brand_image ADD CONSTRAINT FK_C721EBF47E3C61F9 FOREIGN KEY (owner_id) REFERENCES app_brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_brand_translation ADD CONSTRAINT FK_747DC8052C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES app_brand (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE app_brand_channels DROP FOREIGN KEY FK_EBDEE35944F5D008');
        $this->addSql('ALTER TABLE app_brand_channels DROP FOREIGN KEY FK_EBDEE35972F5A1AA');
        $this->addSql('ALTER TABLE app_brand_image DROP FOREIGN KEY FK_C721EBF47E3C61F9');
        $this->addSql('ALTER TABLE app_brand_translation DROP FOREIGN KEY FK_747DC8052C2AC5D3');
        $this->addSql('DROP TABLE app_brand_channels');
        $this->addSql('DROP TABLE app_brand_image');
        $this->addSql('DROP TABLE app_brand_translation');
    }
}
