<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191012122809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product ADD amo_profile_id VARCHAR(255) DEFAULT NULL, ADD wine_service_temp INT NOT NULL, ADD wine_service_decanting VARCHAR(255) NOT NULL, ADD wine_service_meat LONGTEXT NOT NULL, ADD wine_service_cheese LONGTEXT NOT NULL, ADD wine_service_fish LONGTEXT NOT NULL, ADD wine_service_vegetable LONGTEXT NOT NULL, ADD wine_service_dessert LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E031817460DED FOREIGN KEY (amo_profile_id) REFERENCES mps_vine_profile (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_9F3E031817460DED ON amo_product (amo_profile_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E031817460DED');
        $this->addSql('DROP INDEX IDX_9F3E031817460DED ON amo_product');
        $this->addSql('ALTER TABLE amo_product DROP amo_profile_id, DROP wine_service_temp, DROP wine_service_decanting, DROP wine_service_meat, DROP wine_service_cheese, DROP wine_service_fish, DROP wine_service_vegetable, DROP wine_service_dessert');
    }
}
