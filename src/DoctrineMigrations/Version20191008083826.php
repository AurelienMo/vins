<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use App\Domain\Common\Helpers\UuidGenerator;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191008083826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $uuidPink = $this->getUuid();
        $uuidWhite = $this->getUuid();
        $uuidRed = $this->getUuid();

        $this->addSql('CREATE TABLE amo_type_product (id VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql("INSERT INTO amo_type_product (id, created_at, name, slug) VALUES ('$uuidPink', now(), 'Les Rosés', 'les-roses')");
        $this->addSql("INSERT INTO amo_type_product (id, created_at, name, slug) VALUES ('$uuidWhite', now(), 'Les Blancs', 'les-blancs')");
        $this->addSql("INSERT INTO amo_type_product (id, created_at, name, slug) VALUES ('$uuidRed', now(), 'Les Rouges', 'les-rouges')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE amo_type_product');
    }

    private function getUuid()
    {
        return UuidGenerator::generate();
    }
}
