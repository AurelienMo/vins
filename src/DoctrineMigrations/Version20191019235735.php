<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191019235735 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_delivery (id VARCHAR(255) NOT NULL, amo_delivery_type_id VARCHAR(255) DEFAULT NULL, amo_delivery_point_id VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, status_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8CC6DF14A7D981A9 (amo_delivery_type_id), INDEX IDX_8CC6DF14646821D (amo_delivery_point_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14A7D981A9 FOREIGN KEY (amo_delivery_type_id) REFERENCES amo_delivery_type (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14646821D FOREIGN KEY (amo_delivery_point_id) REFERENCES amo_delivery_point (id)');
        $this->addSql('ALTER TABLE amo_order ADD amo_delivery_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D6889C97045 FOREIGN KEY (amo_delivery_id) REFERENCES amo_delivery (id)');
        $this->addSql('CREATE INDEX IDX_55D2D6889C97045 ON amo_order (amo_delivery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D6889C97045');
        $this->addSql('DROP TABLE amo_delivery');
        $this->addSql('DROP INDEX IDX_55D2D6889C97045 ON amo_order');
        $this->addSql('ALTER TABLE amo_order DROP amo_delivery_id');
    }
}
