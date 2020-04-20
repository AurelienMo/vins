<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420163551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_opinion ADD amo_box_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_opinion ADD CONSTRAINT FK_E776B792C500901E FOREIGN KEY (amo_box_id) REFERENCES amo_box_wine (id)');
        $this->addSql('CREATE INDEX IDX_E776B792C500901E ON amo_opinion (amo_box_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_opinion DROP FOREIGN KEY FK_E776B792C500901E');
        $this->addSql('DROP INDEX IDX_E776B792C500901E ON amo_opinion');
        $this->addSql('ALTER TABLE amo_opinion DROP amo_box_id');
    }
}
