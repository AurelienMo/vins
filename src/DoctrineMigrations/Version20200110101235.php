<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200110101235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_box_wine (id VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE box_wine_has_capacities (box_wine_id VARCHAR(255) NOT NULL, capacity_id VARCHAR(255) NOT NULL, INDEX IDX_6889653931602347 (box_wine_id), INDEX IDX_6889653966B6F0BA (capacity_id), PRIMARY KEY(box_wine_id, capacity_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE box_wine_has_capacities ADD CONSTRAINT FK_6889653931602347 FOREIGN KEY (box_wine_id) REFERENCES amo_box_wine (id)');
        $this->addSql('ALTER TABLE box_wine_has_capacities ADD CONSTRAINT FK_6889653966B6F0BA FOREIGN KEY (capacity_id) REFERENCES amo_capacity (id)');
        $this->addSql('ALTER TABLE amo_user CHANGE id id VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_stock_entry CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_stock_id amo_stock_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_quizz CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_wine_id amo_wine_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_wine_domain CHANGE id id VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_promotion CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_product_id amo_product_id VARCHAR(255) DEFAULT NULL, CHANGE amo_type_promotion_id amo_type_promotion_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_delivery_type CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_type_promotion CHANGE id id VARCHAR(255) NOT NULL, CHANGE label label VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_niche_of_delivery CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_delivery_point CHANGE id id VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE address_street_name address_street_name VARCHAR(255) NOT NULL, CHANGE address_zip_code address_zip_code VARCHAR(255) NOT NULL, CHANGE address_city address_city VARCHAR(255) NOT NULL, CHANGE address_country address_country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_stock CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_capacity_id amo_capacity_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE mps_vine_profile CHANGE id id VARCHAR(255) NOT NULL, CHANGE color color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_capacity CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_wine_id amo_wine_id VARCHAR(255) DEFAULT NULL, CHANGE amo_stock_id amo_stock_id VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE quantity quantity VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_answer CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_question_id amo_question_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_customer CHANGE id id VARCHAR(255) NOT NULL, CHANGE civility civility VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL, CHANGE address_street_name address_street_name VARCHAR(255) NOT NULL, CHANGE address_zip_code address_zip_code VARCHAR(255) NOT NULL, CHANGE address_city address_city VARCHAR(255) NOT NULL, CHANGE address_country address_country VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_opinion CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_wine_id amo_wine_id VARCHAR(255) DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_order_product_line CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_wine_id amo_wine_id VARCHAR(255) DEFAULT NULL, CHANGE amo_order_id amo_order_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_question CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_quizz_id amo_quizz_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE amo_order CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_delivery_id amo_delivery_id VARCHAR(255) DEFAULT NULL, CHANGE amo_customer_id amo_customer_id VARCHAR(255) DEFAULT NULL, CHANGE bill_number bill_number VARCHAR(255) NOT NULL, CHANGE order_number order_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_delivery CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_delivery_type_id amo_delivery_type_id VARCHAR(255) DEFAULT NULL, CHANGE amo_delivery_point_id amo_delivery_point_id VARCHAR(255) DEFAULT NULL, CHANGE amo_niche_of_delivery_id amo_niche_of_delivery_id VARCHAR(255) DEFAULT NULL, CHANGE amo_order_id amo_order_id VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_type_product CHANGE id id VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE amo_product CHANGE id id VARCHAR(255) NOT NULL, CHANGE amo_wine_domain_id amo_wine_domain_id VARCHAR(255) DEFAULT NULL, CHANGE amo_type_product_id amo_type_product_id VARCHAR(255) DEFAULT NULL, CHANGE amo_profile_id amo_profile_id VARCHAR(255) DEFAULT NULL, CHANGE vintage_name vintage_name VARCHAR(255) NOT NULL, CHANGE year year VARCHAR(255) NOT NULL, CHANGE appellation appellation VARCHAR(255) NOT NULL, CHANGE wine_service_decanting wine_service_decanting VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE box_wine_has_capacities DROP FOREIGN KEY FK_6889653931602347');
        $this->addSql('DROP TABLE amo_box_wine');
        $this->addSql('DROP TABLE box_wine_has_capacities');
        $this->addSql('ALTER TABLE amo_answer CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_question_id amo_question_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_capacity CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_wine_id amo_wine_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_stock_id amo_stock_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE type type VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE quantity quantity VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_customer CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE civility civility VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE firstname firstname VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE lastname lastname VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_street_name address_street_name VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_zip_code address_zip_code VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_city address_city VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_country address_country VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_delivery CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_delivery_type_id amo_delivery_type_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_delivery_point_id amo_delivery_point_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_niche_of_delivery_id amo_niche_of_delivery_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_order_id amo_order_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE status status VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_delivery_point CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_street_name address_street_name VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_zip_code address_zip_code VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_city address_city VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE address_country address_country VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_delivery_type CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_niche_of_delivery CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_opinion CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_wine_id amo_wine_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE name name VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_order CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_delivery_id amo_delivery_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_customer_id amo_customer_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE bill_number bill_number VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE order_number order_number VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_order_product_line CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_wine_id amo_wine_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_order_id amo_order_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_product CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_wine_domain_id amo_wine_domain_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_type_product_id amo_type_product_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_profile_id amo_profile_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE vintage_name vintage_name VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE year year VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE appellation appellation VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE wine_service_decanting wine_service_decanting VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_promotion CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_product_id amo_product_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_type_promotion_id amo_type_promotion_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_question CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_quizz_id amo_quizz_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_quizz CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_wine_id amo_wine_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_stock CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_capacity_id amo_capacity_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_stock_entry CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE amo_stock_id amo_stock_id VARCHAR(190) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_type_product CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_type_promotion CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE label label VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_user CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE firstname firstname VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE lastname lastname VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE email email VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE password password VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE status status VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE amo_wine_domain CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE slug slug VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE mps_vine_profile CHANGE id id VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE color color VARCHAR(190) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
