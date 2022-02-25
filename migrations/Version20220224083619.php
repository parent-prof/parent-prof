<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224083619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau DROP FOREIGN KEY FK_F9668B5F44A67F3');
        $this->addSql('DROP INDEX IDX_F9668B5F44A67F3 ON creneau');
        $this->addSql('ALTER TABLE creneau DROP reserver_id');
        $this->addSql('ALTER TABLE reserver ADD creneau_id INT NOT NULL, ADD parent_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT FK_B9765E937D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id)');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT FK_B9765E93727ACA70 FOREIGN KEY (parent_id) REFERENCES parents (id)');
        $this->addSql('CREATE INDEX IDX_B9765E937D0729A9 ON reserver (creneau_id)');
        $this->addSql('CREATE INDEX IDX_B9765E93727ACA70 ON reserver (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creneau ADD reserver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F44A67F3 FOREIGN KEY (reserver_id) REFERENCES reserver (id)');
        $this->addSql('CREATE INDEX IDX_F9668B5F44A67F3 ON creneau (reserver_id)');
        $this->addSql('ALTER TABLE eleve CHANGE matricule matricule VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE promotion CHANGE nom nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reserver DROP FOREIGN KEY FK_B9765E937D0729A9');
        $this->addSql('ALTER TABLE reserver DROP FOREIGN KEY FK_B9765E93727ACA70');
        $this->addSql('DROP INDEX IDX_B9765E937D0729A9 ON reserver');
        $this->addSql('DROP INDEX IDX_B9765E93727ACA70 ON reserver');
        $this->addSql('ALTER TABLE reserver DROP creneau_id, DROP parent_id');
        $this->addSql('ALTER TABLE utilisateur CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mdp mdp VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
