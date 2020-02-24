<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200224234828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {

        $this->addSql("DELETE FROM amo_wine_agreement WHERE name = 'Viande maigre'");
        $this->addSql("DELETE FROM amo_wine_agreement WHERE name = 'Viande grasse'");
        $id = Uuid::uuid4()->toString();
        $item = [
            'id' => $id,
            'name' => 'Viande blanche',
            'order' => 9
        ];
        $this->addSql("INSERT INTO amo_wine_agreement (id, name, order_value) VALUES (:id, :name, :order)", $item);

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
