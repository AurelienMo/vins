<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200209225256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14646821D');
        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14A7D981A9');
        $this->addSql('DROP INDEX IDX_8CC6DF14A7D981A9 ON amo_delivery');
        $this->addSql('DROP INDEX IDX_8CC6DF14646821D ON amo_delivery');
        $this->addSql('ALTER TABLE amo_delivery DROP amo_delivery_type_id, DROP amo_delivery_point_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_delivery ADD amo_delivery_type_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD amo_delivery_point_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14646821D FOREIGN KEY (amo_delivery_point_id) REFERENCES amo_delivery_point (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14A7D981A9 FOREIGN KEY (amo_delivery_type_id) REFERENCES amo_delivery_type (id)');
        $this->addSql('CREATE INDEX IDX_8CC6DF14A7D981A9 ON amo_delivery (amo_delivery_type_id)');
        $this->addSql('CREATE INDEX IDX_8CC6DF14646821D ON amo_delivery (amo_delivery_point_id)');
    }
}
