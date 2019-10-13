<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191012230038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_order_product_line (id VARCHAR(255) NOT NULL, amo_wine_id VARCHAR(255) DEFAULT NULL, amo_order_id VARCHAR(255) DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_47418EFE64D6BAC3 (amo_wine_id), INDEX IDX_47418EFE36D85E3C (amo_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_order (id VARCHAR(255) NOT NULL, order_at DATETIME NOT NULL, status VARCHAR(255) NOT NULL, bill_number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE64D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE36D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE36D85E3C');
        $this->addSql('DROP TABLE amo_order_product_line');
        $this->addSql('DROP TABLE amo_order');
    }
}
