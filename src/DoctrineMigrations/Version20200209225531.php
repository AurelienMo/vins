<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209225531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE64D6BAC3');
        $this->addSql('DROP INDEX IDX_47418EFE64D6BAC3 ON amo_order_product_line');
        $this->addSql('ALTER TABLE amo_order_product_line DROP amo_wine_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line ADD amo_wine_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE64D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('CREATE INDEX IDX_47418EFE64D6BAC3 ON amo_order_product_line (amo_wine_id)');
    }
}
