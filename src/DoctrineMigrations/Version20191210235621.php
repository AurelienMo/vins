<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191210235621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE amo_user (id VARCHAR(190) NOT NULL, firstname VARCHAR(190) NOT NULL, lastname VARCHAR(190) NOT NULL, email VARCHAR(190) NOT NULL, password VARCHAR(190) NOT NULL, status VARCHAR(190) NOT NULL, slug VARCHAR(190) NOT NULL, token_reset_password VARCHAR(255) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mps_vine_profile (id VARCHAR(190) NOT NULL, color VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_type_product (id VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(190) NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_niche_of_delivery (id VARCHAR(190) NOT NULL, date_niche DATETIME NOT NULL, number_niche INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_delivery_type (id VARCHAR(190) NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_stock_entry (id VARCHAR(190) NOT NULL, amo_stock_id VARCHAR(190) DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_ACEB98E5B68A5214 (amo_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_delivery (id VARCHAR(190) NOT NULL, amo_delivery_type_id VARCHAR(190) DEFAULT NULL, amo_delivery_point_id VARCHAR(190) DEFAULT NULL, amo_niche_of_delivery_id VARCHAR(190) DEFAULT NULL, amo_order_id VARCHAR(190) DEFAULT NULL, status VARCHAR(190) NOT NULL, status_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8CC6DF14A7D981A9 (amo_delivery_type_id), INDEX IDX_8CC6DF14646821D (amo_delivery_point_id), INDEX IDX_8CC6DF14CAAA2A9D (amo_niche_of_delivery_id), UNIQUE INDEX UNIQ_8CC6DF1436D85E3C (amo_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_quizz (id VARCHAR(190) NOT NULL, amo_wine_id VARCHAR(190) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_DC8CD22D64D6BAC3 (amo_wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_product (id VARCHAR(190) NOT NULL, amo_wine_domain_id VARCHAR(190) DEFAULT NULL, amo_type_product_id VARCHAR(190) DEFAULT NULL, amo_profile_id VARCHAR(190) DEFAULT NULL, vintage_name VARCHAR(190) NOT NULL, year VARCHAR(190) NOT NULL, appellation VARCHAR(190) NOT NULL, tva_rate DOUBLE PRECISION NOT NULL, active TINYINT(1) NOT NULL, is_promote TINYINT(1) NOT NULL, image_path VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, wine_caract_powerful INT NOT NULL, wine_caract_complex INT NOT NULL, wine_caract_spice INT NOT NULL, wine_caract_fruity INT NOT NULL, wine_caract_wooded INT NOT NULL, wine_caract_tannic INT NOT NULL, wine_service_temp INT NOT NULL, wine_service_decanting VARCHAR(190) NOT NULL, wine_service_meat LONGTEXT NOT NULL, wine_service_cheese LONGTEXT NOT NULL, wine_service_fish LONGTEXT NOT NULL, wine_service_vegetable LONGTEXT NOT NULL, wine_service_dessert LONGTEXT NOT NULL, INDEX IDX_9F3E03183A0E0323 (amo_wine_domain_id), INDEX IDX_9F3E0318E86ACAD (amo_type_product_id), INDEX IDX_9F3E031817460DED (amo_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_promotion (id VARCHAR(190) NOT NULL, amo_product_id VARCHAR(190) DEFAULT NULL, amo_type_promotion_id VARCHAR(190) DEFAULT NULL, value DOUBLE PRECISION NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_C6CBFEFB9E38790F (amo_product_id), INDEX IDX_C6CBFEFB33D1E642 (amo_type_promotion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_wine_domain (id VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, slug VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_delivery_point (id VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(190) NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, address_street_number VARCHAR(255) DEFAULT NULL, address_street_name VARCHAR(190) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, address_zip_code VARCHAR(190) NOT NULL, address_city VARCHAR(190) NOT NULL, address_country VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_stock (id VARCHAR(190) NOT NULL, amo_capacity_id VARCHAR(190) DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EBCD13707D6CE9DE (amo_capacity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_capacity (id VARCHAR(190) NOT NULL, amo_wine_id VARCHAR(190) DEFAULT NULL, amo_stock_id VARCHAR(190) DEFAULT NULL, type VARCHAR(190) NOT NULL, quantity VARCHAR(190) NOT NULL, unit_price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_EAF827064D6BAC3 (amo_wine_id), UNIQUE INDEX UNIQ_EAF8270B68A5214 (amo_stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_order (id VARCHAR(190) NOT NULL, amo_delivery_id VARCHAR(190) DEFAULT NULL, amo_customer_id VARCHAR(190) DEFAULT NULL, order_at DATETIME NOT NULL, bill_number VARCHAR(190) NOT NULL, order_number VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_55D2D6889C97045 (amo_delivery_id), UNIQUE INDEX UNIQ_55D2D688884FDA97 (amo_customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_opinion (id VARCHAR(190) NOT NULL, amo_wine_id VARCHAR(190) DEFAULT NULL, name VARCHAR(190) NOT NULL, rate INT NOT NULL, content LONGTEXT DEFAULT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E776B79264D6BAC3 (amo_wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_question (id VARCHAR(190) NOT NULL, amo_quizz_id VARCHAR(190) DEFAULT NULL, label LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DB07A4A1D478C9 (amo_quizz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_answer (id VARCHAR(190) NOT NULL, amo_question_id VARCHAR(190) DEFAULT NULL, label LONGTEXT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_C7CAA1045FDEFDB (amo_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_customer (id VARCHAR(190) NOT NULL, civility VARCHAR(190) NOT NULL, firstname VARCHAR(190) NOT NULL, lastname VARCHAR(190) NOT NULL, rgpd_ok TINYINT(1) NOT NULL, rgpd_accepted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, address_street_number VARCHAR(255) DEFAULT NULL, address_street_name VARCHAR(190) NOT NULL, address_complement VARCHAR(255) DEFAULT NULL, address_zip_code VARCHAR(190) NOT NULL, address_city VARCHAR(190) NOT NULL, address_country VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_type_promotion (id VARCHAR(190) NOT NULL, label VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amo_order_product_line (id VARCHAR(190) NOT NULL, amo_wine_id VARCHAR(190) DEFAULT NULL, amo_order_id VARCHAR(190) DEFAULT NULL, quantity INT NOT NULL, amount DOUBLE PRECISION NOT NULL, tva_rate DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_47418EFE64D6BAC3 (amo_wine_id), INDEX IDX_47418EFE36D85E3C (amo_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE amo_stock_entry ADD CONSTRAINT FK_ACEB98E5B68A5214 FOREIGN KEY (amo_stock_id) REFERENCES amo_stock (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14A7D981A9 FOREIGN KEY (amo_delivery_type_id) REFERENCES amo_delivery_type (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14646821D FOREIGN KEY (amo_delivery_point_id) REFERENCES amo_delivery_point (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF14CAAA2A9D FOREIGN KEY (amo_niche_of_delivery_id) REFERENCES amo_niche_of_delivery (id)');
        $this->addSql('ALTER TABLE amo_delivery ADD CONSTRAINT FK_8CC6DF1436D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_quizz ADD CONSTRAINT FK_DC8CD22D64D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E03183A0E0323 FOREIGN KEY (amo_wine_domain_id) REFERENCES amo_wine_domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E0318E86ACAD FOREIGN KEY (amo_type_product_id) REFERENCES amo_type_product (id)');
        $this->addSql('ALTER TABLE amo_product ADD CONSTRAINT FK_9F3E031817460DED FOREIGN KEY (amo_profile_id) REFERENCES mps_vine_profile (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE amo_promotion ADD CONSTRAINT FK_C6CBFEFB9E38790F FOREIGN KEY (amo_product_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_promotion ADD CONSTRAINT FK_C6CBFEFB33D1E642 FOREIGN KEY (amo_type_promotion_id) REFERENCES amo_type_promotion (id)');
        $this->addSql('ALTER TABLE amo_stock ADD CONSTRAINT FK_EBCD13707D6CE9DE FOREIGN KEY (amo_capacity_id) REFERENCES amo_capacity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_capacity ADD CONSTRAINT FK_EAF827064D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_capacity ADD CONSTRAINT FK_EAF8270B68A5214 FOREIGN KEY (amo_stock_id) REFERENCES amo_stock (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D6889C97045 FOREIGN KEY (amo_delivery_id) REFERENCES amo_delivery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amo_order ADD CONSTRAINT FK_55D2D688884FDA97 FOREIGN KEY (amo_customer_id) REFERENCES amo_customer (id)');
        $this->addSql('ALTER TABLE amo_opinion ADD CONSTRAINT FK_E776B79264D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_question ADD CONSTRAINT FK_DB07A4A1D478C9 FOREIGN KEY (amo_quizz_id) REFERENCES amo_quizz (id)');
        $this->addSql('ALTER TABLE amo_answer ADD CONSTRAINT FK_C7CAA1045FDEFDB FOREIGN KEY (amo_question_id) REFERENCES amo_question (id)');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE64D6BAC3 FOREIGN KEY (amo_wine_id) REFERENCES amo_product (id)');
        $this->addSql('ALTER TABLE amo_order_product_line ADD CONSTRAINT FK_47418EFE36D85E3C FOREIGN KEY (amo_order_id) REFERENCES amo_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E031817460DED');
        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E0318E86ACAD');
        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14CAAA2A9D');
        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14A7D981A9');
        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D6889C97045');
        $this->addSql('ALTER TABLE amo_question DROP FOREIGN KEY FK_DB07A4A1D478C9');
        $this->addSql('ALTER TABLE amo_quizz DROP FOREIGN KEY FK_DC8CD22D64D6BAC3');
        $this->addSql('ALTER TABLE amo_promotion DROP FOREIGN KEY FK_C6CBFEFB9E38790F');
        $this->addSql('ALTER TABLE amo_capacity DROP FOREIGN KEY FK_EAF827064D6BAC3');
        $this->addSql('ALTER TABLE amo_opinion DROP FOREIGN KEY FK_E776B79264D6BAC3');
        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE64D6BAC3');
        $this->addSql('ALTER TABLE amo_product DROP FOREIGN KEY FK_9F3E03183A0E0323');
        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF14646821D');
        $this->addSql('ALTER TABLE amo_stock_entry DROP FOREIGN KEY FK_ACEB98E5B68A5214');
        $this->addSql('ALTER TABLE amo_capacity DROP FOREIGN KEY FK_EAF8270B68A5214');
        $this->addSql('ALTER TABLE amo_stock DROP FOREIGN KEY FK_EBCD13707D6CE9DE');
        $this->addSql('ALTER TABLE amo_delivery DROP FOREIGN KEY FK_8CC6DF1436D85E3C');
        $this->addSql('ALTER TABLE amo_order_product_line DROP FOREIGN KEY FK_47418EFE36D85E3C');
        $this->addSql('ALTER TABLE amo_answer DROP FOREIGN KEY FK_C7CAA1045FDEFDB');
        $this->addSql('ALTER TABLE amo_order DROP FOREIGN KEY FK_55D2D688884FDA97');
        $this->addSql('ALTER TABLE amo_promotion DROP FOREIGN KEY FK_C6CBFEFB33D1E642');
        $this->addSql('DROP TABLE amo_user');
        $this->addSql('DROP TABLE mps_vine_profile');
        $this->addSql('DROP TABLE amo_type_product');
        $this->addSql('DROP TABLE amo_niche_of_delivery');
        $this->addSql('DROP TABLE amo_delivery_type');
        $this->addSql('DROP TABLE amo_stock_entry');
        $this->addSql('DROP TABLE amo_delivery');
        $this->addSql('DROP TABLE amo_quizz');
        $this->addSql('DROP TABLE amo_product');
        $this->addSql('DROP TABLE amo_promotion');
        $this->addSql('DROP TABLE amo_wine_domain');
        $this->addSql('DROP TABLE amo_delivery_point');
        $this->addSql('DROP TABLE amo_stock');
        $this->addSql('DROP TABLE amo_capacity');
        $this->addSql('DROP TABLE amo_order');
        $this->addSql('DROP TABLE amo_opinion');
        $this->addSql('DROP TABLE amo_question');
        $this->addSql('DROP TABLE amo_answer');
        $this->addSql('DROP TABLE amo_customer');
        $this->addSql('DROP TABLE amo_type_promotion');
        $this->addSql('DROP TABLE amo_order_product_line');
    }
}
