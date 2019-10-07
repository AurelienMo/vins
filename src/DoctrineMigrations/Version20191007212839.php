<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191007212839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_promotion (id VARCHAR(255) NOT NULL, amo_product_id VARCHAR(255) DEFAULT NULL, amo_type_promotion_id VARCHAR(255) DEFAULT NULL, value DOUBLE PRECISION NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_C6CBFEFB9E38790F (amo_product_id), INDEX IDX_C6CBFEFB33D1E642 (amo_type_promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_product (id VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, vintage_name VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, appellation VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_promotion ADD CONSTRAINT FK_C6CBFEFB9E38790F FOREIGN KEY (amo_product_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_promotion ADD CONSTRAINT FK_C6CBFEFB33D1E642 FOREIGN KEY (amo_type_promotion_id) REFERENCES amo_type_promotion (id)');
        $this->addSql('ALTER TABLE amo_type_promotion CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mps_vine_profile CHANGE name name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_promotion DROP FOREIGN KEY FK_C6CBFEFB9E38790F');
        $this->addSql('DROP TABLE amo_promotion');
        $this->addSql('DROP TABLE amo_product');
        $this->addSql('ALTER TABLE amo_type_promotion CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE mps_vine_profile CHANGE name name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
