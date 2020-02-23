<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200223083219 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM amo_wine_agreement");
        $this->addSql('ALTER TABLE amo_wine_agreement ADD `order_value` INT NOT NULL');
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
        foreach ($listFields as $index => $field) {
            $id = Uuid::uuid4()->toString();
            $item = [
                'id' => $id,
                'name' => $field,
                'order' => (int) $index + 1
            ];
            $this->addSql("INSERT INTO amo_wine_agreement (id, name, order_value) VALUES (:id, :name, :order)", $item);
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE amo_wine_agreement DROP `order`');
    }
}
