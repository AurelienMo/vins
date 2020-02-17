<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200217145644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_tastuce_theme (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, color_text VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_tastuce (id VARCHAR(255) NOT NULL, tastuce_theme_id VARCHAR(255) DEFAULT NULL, pdf_path VARCHAR(255) NOT NULL, text_link VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_718A5AD023B046EC (tastuce_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_tastuce ADD CONSTRAINT FK_718A5AD023B046EC FOREIGN KEY (tastuce_theme_id) REFERENCES amo_tastuce_theme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_tastuce DROP FOREIGN KEY FK_718A5AD023B046EC');
        $this->addSql('DROP TABLE amo_tastuce_theme');
        $this->addSql('DROP TABLE amo_tastuce');
    }
}
