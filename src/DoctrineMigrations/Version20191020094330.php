<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191020094330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_niche_of_delivery (id VARCHAR(255) NOT NULL, date_niche DATETIME NOT NULL, number_niche INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_delivery ADD amo_niche_of_delivery_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14CAAA2A9D FOREIGN KEY (amo_niche_of_delivery_id) REFERENCES amo_niche_of_delivery (id)');
        $this->addSql('CREATE INDEX IDX_8CC6DF14CAAA2A9D ON amo_delivery (amo_niche_of_delivery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14CAAA2A9D');
        $this->addSql('DROP TABLE amo_niche_of_delivery');
        $this->addSql('DROP INDEX IDX_8CC6DF14CAAA2A9D ON amo_delivery');
        $this->addSql('ALTER TABLE amo_delivery DROP amo_niche_of_delivery_id');
    }
}
