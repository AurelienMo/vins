<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200415154012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_stock_entry ADD order_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_stock_entry ADD CONSTRAINT FK_ACEB98E58D9F6D38 FOREIGN KEY (order_id) REFERENCES amo_order (id)');
        $this->addSql('CREATE INDEX IDX_ACEB98E58D9F6D38 ON amo_stock_entry (order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_stock_entry DROP FOREIGN KEY FK_ACEB98E58D9F6D38');
        $this->addSql('DROP INDEX IDX_ACEB98E58D9F6D38 ON amo_stock_entry');
        $this->addSql('ALTER TABLE amo_stock_entry DROP order_id');
    }
}
