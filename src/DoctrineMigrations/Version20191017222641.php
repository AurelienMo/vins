<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017222641 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_stock (id VARCHAR(255) NOT NULL, amo_wine_id VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EBCD137064D6BAC3 (amo_wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_stock ADD CONSTRAINT FK_EBCD137064D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_product ADD amo_stock_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E0318B68A5214 FOREIGN KEY (amo_stock_id) REFERENCES amo_stock (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F3E0318B68A5214 ON amo_product (amo_stock_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E0318B68A5214');
        $this->addSql('DROP TABLE amo_stock');
        $this->addSql('DROP INDEX UNIQ_9F3E0318B68A5214 ON amo_product');
        $this->addSql('ALTER TABLE amo_product DROP amo_stock_id');
    }
}
