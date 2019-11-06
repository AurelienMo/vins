<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105234836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D6889C97045');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D6889C97045 FOREIGN KEY (amo_delivery_id) REFERENCES amo_delivery (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D6889C97045');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D6889C97045 FOREIGN KEY (amo_delivery_id) REFERENCES amo_delivery (id)');
    }
}
