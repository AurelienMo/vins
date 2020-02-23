<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200223081351 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $listFields = [
            'Poisson maigre',
            'Crustacés',
            'Poisson gras',
            'Légumes',
            'Fromage frais',
            'Fromage doux',
            'Fromage fort',
            'Charcuterie',
            'Viande maigre',
            'Viande grasse',
            'Viande rouge',
            'Gibiers',
            'Sauce rouge',
            'Sauce blanche',
            'Sauce piquante',
            'Sauce poivre',
            'Sauce huile',
        ];
        foreach ($listFields as $field) {
            $id = Uuid::uuid4()->toString();
            $item = [
                'id' => $id,
                'name' => $field,
            ];
            $this->addSql("INSERT INTO amo_wine_agreement (id, name) VALUES (:id, :name)", $item);
        }
        // this up() migration is auto-generated, please modify it to your needs

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
