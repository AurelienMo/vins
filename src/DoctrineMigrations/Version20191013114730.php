<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191013114730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line ADD amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E031817460DED');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E031817460DED FOREIGN KEY (amo_profile_id) REFERENCES mps_vine_profile (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line DROP amount');
        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E031817460DED');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E031817460DED FOREIGN KEY (amo_profile_id) REFERENCES mps_vine_profile (id) ON DELETE CASCADE');
    }
}
