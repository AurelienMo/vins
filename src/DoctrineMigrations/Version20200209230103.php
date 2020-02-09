<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209230103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line ADD amo_capacity_wine_id VARCHAR(255) DEFAULT NULL, ADD wine_name VARCHAR(255) NOT NULL, ADD type_capacity VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFEB8492B1A FOREIGN KEY (amo_capacity_wine_id) REFERENCES amo_capacity (id)');
        $this->addSql('CREATE INDEX IDX_47418EFEB8492B1A ON amo_order_product_line (amo_capacity_wine_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFEB8492B1A');
        $this->addSql('DROP INDEX IDX_47418EFEB8492B1A ON amo_order_product_line');
        $this->addSql('ALTER TABLE amo_order_product_line DROP amo_capacity_wine_id, DROP wine_name, DROP type_capacity');
    }
}
