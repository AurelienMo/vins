<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191010230026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_wine_domain (id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_product ADD amo_wine_domain_id VARCHAR(255) DEFAULT NULL, DROP domain');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E03183A0E0323 FOREIGN KEY (amo_wine_domain_id) REFERENCES amo_wine_domain (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9F3E03183A0E0323 ON amo_product (amo_wine_domain_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E03183A0E0323');
        $this->addSql('DROP TABLE amo_wine_domain');
        $this->addSql('DROP INDEX IDX_9F3E03183A0E0323 ON amo_product');
        $this->addSql('ALTER TABLE amo_product ADD domain VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP amo_wine_domain_id');
    }
}
