<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200223081200 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_wine_agreement (product_id VARCHAR(255) NOT NULL, wine_agreement_id VARCHAR(255) NOT NULL, INDEX IDX_E485D8FB4584665A (product_id), INDEX IDX_E485D8FBBF66530E (wine_agreement_id), PRIMARY KEY(product_id, wine_agreement_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_wine_agreement (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_wine_agreement ADD CONSTRAINT FK_E485D8FB4584665A FOREIGN KEY (product_id) REFERENCES amo_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_wine_agreement ADD CONSTRAINT FK_E485D8FBBF66530E FOREIGN KEY (wine_agreement_id) REFERENCES amo_wine_agreement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_wine_agreement DROP FOREIGN KEY FK_E485D8FBBF66530E');
        $this->addSql('DROP TABLE product_wine_agreement');
        $this->addSql('DROP TABLE amo_wine_agreement');
    }
}
