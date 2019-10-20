<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020230027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_customer (id VARCHAR(255) NOT NULL, amo_order_id VARCHAR(255) DEFAULT NULL, civility VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, rgpd_accepted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, address_street_number VARCHAR(255) DEFAULT NULL, address_street_name VARCHAR(255) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, address_zip_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_country VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3A7EBD0D36D85E3C (amo_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_customer ADD CONSTRAINT FK_3A7EBD0D36D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
        $this->addSql('ALTER TABLE amo_order ADD amo_customer_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D688884FDA97 FOREIGN KEY (amo_customer_id) REFERENCES amo_customer (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55D2D688884FDA97 ON amo_order (amo_customer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D688884FDA97');
        $this->addSql('DROP TABLE amo_customer');
        $this->addSql('DROP INDEX UNIQ_55D2D688884FDA97 ON amo_order');
        $this->addSql('ALTER TABLE amo_order DROP amo_customer_id');
    }
}
