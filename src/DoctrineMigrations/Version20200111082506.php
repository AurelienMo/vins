<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200111082506 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $uuidPercent = Uuid::uuid4()->toString();
        $uuidAmount = Uuid::uuid4()->toString();
        $this->addSql("INSERT INTO amo_type_promotion (id, name, label, created_at) VALUES ('$uuidPercent', 'Pourcentage', '%', now())");
        $this->addSql("INSERT INTO amo_type_promotion (id, name, label, created_at) VALUES ('$uuidAmount', 'Montant', '€', now())");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
