<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008084725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product ADD amo_type_product_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E0318E86ACAD FOREIGN KEY (amo_type_product_id) REFERENCES amo_type_product (id)');
        $this->addSql('CREATE INDEX IDX_9F3E0318E86ACAD ON amo_product (amo_type_product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E0318E86ACAD');
        $this->addSql('DROP INDEX IDX_9F3E0318E86ACAD ON amo_product');
        $this->addSql('ALTER TABLE amo_product DROP amo_type_product_id');
    }
}
