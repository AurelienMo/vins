<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105232856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_delivery ADD amo_order_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF1436D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8CC6DF1436D85E3C ON amo_delivery (amo_order_id)');
        $this->addSql('ALTER TABLE amo_order DROP INDEX IDX_55D2D6889C97045, ADD UNIQUE INDEX UNIQ_55D2D6889C97045 (amo_delivery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF1436D85E3C');
        $this->addSql('DROP INDEX UNIQ_8CC6DF1436D85E3C ON amo_delivery');
        $this->addSql('ALTER TABLE amo_delivery DROP amo_order_id');
        $this->addSql('ALTER TABLE amo_order DROP INDEX UNIQ_55D2D6889C97045, ADD INDEX IDX_55D2D6889C97045 (amo_delivery_id)');
    }
}
