<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020235705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_customer DROP FOREIGN KEY FK_3A7EBD0D36D85E3C');
        $this->addSql('DROP INDEX UNIQ_3A7EBD0D36D85E3C ON amo_customer');
        $this->addSql('ALTER TABLE amo_customer DROP amo_order_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_customer ADD amo_order_id VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE amo_customer ADD CONSTRAINT FK_3A7EBD0D36D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3A7EBD0D36D85E3C ON amo_customer (amo_order_id)');
    }
}
