<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214214522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, id_professeur_id INT NOT NULL, heure_fin TIME NOT NULL, date_dispo DATE NOT NULL, heure_debut TIME NOT NULL, duree INT NOT NULL, nb_plage INT NOT NULL, UNIQUE INDEX UNIQ_2CBACE2F49AFF8C (id_professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2F49AFF8C FOREIGN KEY (id_professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE promotion ADD disponibilite_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD12B9D6493 FOREIGN KEY (disponibilite_id) REFERENCES disponibilite (id)');
        $this->addSql('CREATE INDEX IDX_C11D7DD12B9D6493 ON promotion (disponibilite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD12B9D6493');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP INDEX IDX_C11D7DD12B9D6493 ON promotion');
        $this->addSql('ALTER TABLE promotion DROP disponibilite_id, CHANGE nom_promotion nom_promotion VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
