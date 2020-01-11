<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200111003134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO amo_delivery_type (id, price, name, created_at) VALUES ('3ffed71c-e37e-4542-9561-4da9aecb0bdf', 0, 'A l''adresse', now())");
        $this->addSql("INSERT INTO amo_delivery_type (id, price, name, created_at) VALUES ('3af388d8-823f-4ba6-8fe7-db1c6e014845', 0, 'Point relais', now())");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
