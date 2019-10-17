<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017224317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_stock_entry (id VARCHAR(255) NOT NULL, amo_stock_entry VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_ACEB98E5ACEB98E5 (amo_stock_entry), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_stock_entry ADD CONSTRAINT FK_ACEB98E5ACEB98E5 FOREIGN KEY (amo_stock_entry) REFERENCES amo_stock_entry (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_stock_entry DROP FOREIGN KEY FK_ACEB98E5ACEB98E5');
        $this->addSql('DROP TABLE amo_stock_entry');
    }
}
