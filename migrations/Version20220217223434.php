<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220217223434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reserver (id INT AUTO_INCREMENT NOT NULL, id_parent INT NOT NULL, heure_fin TIME NOT NULL, date_dispo DATE NOT NULL, heure_debut TIME NOT NULL, h_debut TIME NOT NULL, h_fin TIME NOT NULL, confirmation TINYINT(1) NOT NULL, relation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reserver');
        $this->addSql('ALTER TABLE promotion CHANGE nom_promotion nom_promotion VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
