<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191017230746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_stock_entry DROP FOREIGN KEY FK_ACEB98E5ACEB98E5');
        $this->addSql('DROP INDEX IDX_ACEB98E5ACEB98E5 ON amo_stock_entry');
        $this->addSql('ALTER TABLE amo_stock_entry CHANGE amo_stock_entry amo_stock_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_stock_entry ADD CONSTRAINT FK_ACEB98E5B68A5214 FOREIGN KEY (amo_stock_id) REFERENCES amo_stock (id)');
        $this->addSql('CREATE INDEX IDX_ACEB98E5B68A5214 ON amo_stock_entry (amo_stock_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_stock_entry DROP FOREIGN KEY FK_ACEB98E5B68A5214');
        $this->addSql('DROP INDEX IDX_ACEB98E5B68A5214 ON amo_stock_entry');
        $this->addSql('ALTER TABLE amo_stock_entry CHANGE amo_stock_id amo_stock_entry VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE amo_stock_entry ADD CONSTRAINT FK_ACEB98E5ACEB98E5 FOREIGN KEY (amo_stock_entry) REFERENCES amo_stock_entry (id)');
        $this->addSql('CREATE INDEX IDX_ACEB98E5ACEB98E5 ON amo_stock_entry (amo_stock_entry)');
    }
}
