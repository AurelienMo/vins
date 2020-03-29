<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200314235341 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE36D85E3C');
        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFEB8492B1A');
        $this->addSql('DROP INDEX IDX_47418EFEB8492B1A ON amo_order_product_line');
        $this->addSql('DROP INDEX IDX_47418EFE36D85E3C ON amo_order_product_line');
        $this->addSql('ALTER TABLE amo_order_product_line ADD order_id VARCHAR(255) DEFAULT NULL, ADD vintage_name VARCHAR(255) NOT NULL, ADD year VARCHAR(255) NOT NULL, ADD domain VARCHAR(255) NOT NULL, ADD appellation VARCHAR(255) NOT NULL, ADD capacity_name VARCHAR(255) NOT NULL, ADD litrage VARCHAR(255) NOT NULL, ADD unit_price DOUBLE PRECISION NOT NULL, ADD type_promotion VARCHAR(255) DEFAULT NULL, ADD value_promotion DOUBLE PRECISION DEFAULT NULL, DROP amo_order_id, DROP amo_capacity_wine_id, DROP amount, DROP tva_rate, DROP wine_name, DROP type_capacity');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE8D9F6D38 FOREIGN KEY (order_id) REFERENCES amo_order (id)');
        $this->addSql('CREATE INDEX IDX_47418EFE8D9F6D38 ON amo_order_product_line (order_id)');
        $this->addSql('ALTER TABLE amo_order ADD customer_stripe_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_order DROP customer_stripe_id');
        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE8D9F6D38');
        $this->addSql('DROP INDEX IDX_47418EFE8D9F6D38 ON amo_order_product_line');
        $this->addSql('ALTER TABLE amo_order_product_line ADD amo_order_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD amo_capacity_wine_id VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD tva_rate DOUBLE PRECISION NOT NULL, ADD wine_name VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD type_capacity VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP order_id, DROP vintage_name, DROP year, DROP domain, DROP appellation, DROP capacity_name, DROP litrage, DROP type_promotion, DROP value_promotion, CHANGE unit_price amount DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE36D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFEB8492B1A FOREIGN KEY (amo_capacity_wine_id) REFERENCES amo_capacity (id)');
        $this->addSql('CREATE INDEX IDX_47418EFEB8492B1A ON amo_order_product_line (amo_capacity_wine_id)');
        $this->addSql('CREATE INDEX IDX_47418EFE36D85E3C ON amo_order_product_line (amo_order_id)');
    }
}
