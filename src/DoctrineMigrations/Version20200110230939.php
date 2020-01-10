<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200110230939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product ADD wine_service_opportunity VARCHAR(255) NOT NULL, DROP wine_service_meat, DROP wine_service_cheese, DROP wine_service_fish, DROP wine_service_vegetable, DROP wine_service_dessert, CHANGE wine_service_decanting wine_service_decanting TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product ADD wine_service_meat LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD wine_service_cheese LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD wine_service_fish LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD wine_service_vegetable LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD wine_service_dessert LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP wine_service_opportunity, CHANGE wine_service_decanting wine_service_decanting VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
