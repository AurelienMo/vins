<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191120072125 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_capacity (id VARCHAR(255) NOT NULL, amo_wine_id VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, quantity VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_EAF827064D6BAC3 (amo_wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_capacity ADD CONSTRAINT FK_EAF827064D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_product DROP price');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amo_capacity');
        $this->addSql('ALTER TABLE amo_product ADD price DOUBLE PRECISION NOT NULL');
    }
}
