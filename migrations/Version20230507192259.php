<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507192259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id_annonce INT AUTO_INCREMENT NOT NULL, id_quiz INT DEFAULT NULL, id_categorie INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, titre VARCHAR(50) NOT NULL, nom_societe VARCHAR(50) NOT NULL, datedebut DATE NOT NULL, datefin DATE NOT NULL, description VARCHAR(50) NOT NULL, type_contrat VARCHAR(50) NOT NULL, INDEX IDX_F65593E52F32E690 (id_quiz), INDEX IDX_F65593E5C9486A13 (id_categorie), INDEX IDX_F65593E550EAE44 (id_utilisateur), PRIMARY KEY(id_annonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (id_candidature INT AUTO_INCREMENT NOT NULL, id_annonce INT DEFAULT NULL, id_demandeur INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_E33BD3B828C83A95 (id_annonce), INDEX IDX_E33BD3B8E6681A34 (id_demandeur), PRIMARY KEY(id_candidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id_categorie INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id_categorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id_file VARCHAR(255) NOT NULL, id_utilisateur INT DEFAULT NULL, cv LONGBLOB DEFAULT NULL, deplome LONGBLOB DEFAULT NULL, lettermotivation LONGBLOB DEFAULT NULL, namecv VARCHAR(255) NOT NULL, namedeplome VARCHAR(255) NOT NULL, namemotivation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8C9F361050EAE44 (id_utilisateur), PRIMARY KEY(id_file)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id_notification INT AUTO_INCREMENT NOT NULL, id_utilisateur INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(150) NOT NULL, INDEX IDX_BF5476CA50EAE44 (id_utilisateur), PRIMARY KEY(id_notification)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id VARCHAR(255) NOT NULL, id_annonce INT DEFAULT NULL, id_utilisateur INT DEFAULT NULL, id_file VARCHAR(255) DEFAULT NULL, etat VARCHAR(50) NOT NULL, date DATE NOT NULL, INDEX IDX_DA7D4E9B28C83A95 (id_annonce), INDEX IDX_DA7D4E9B50EAE44 (id_utilisateur), INDEX IDX_DA7D4E9B7BF2A12 (id_file), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_question INT AUTO_INCREMENT NOT NULL, id_quiz INT DEFAULT NULL, question VARCHAR(255) NOT NULL, propositiona VARCHAR(255) NOT NULL, propositionb VARCHAR(255) NOT NULL, propositionc VARCHAR(255) NOT NULL, id_bonnereponse VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E2F32E690 (id_quiz), PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id_quiz INT AUTO_INCREMENT NOT NULL, id_utilisateur INT DEFAULT NULL, nombre_questions INT NOT NULL, barem VARCHAR(255) NOT NULL, sujet_quiz VARCHAR(255) NOT NULL, INDEX IDX_A412FA9250EAE44 (id_utilisateur), PRIMARY KEY(id_quiz)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id_reclamation INT AUTO_INCREMENT NOT NULL, id_utilisateur INT DEFAULT NULL, date DATE NOT NULL, titre VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_CE60640450EAE44 (id_utilisateur), PRIMARY KEY(id_reclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id_rendez_vous VARCHAR(255) NOT NULL, id_annonce INT DEFAULT NULL, id_user INT DEFAULT NULL, date_rendez_vous DATE NOT NULL, heure_rendez_vous VARCHAR(30) NOT NULL, INDEX IDX_65E8AA0A28C83A95 (id_annonce), INDEX IDX_65E8AA0A6B3CA4B (id_user), PRIMARY KEY(id_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_reclamation (id_reponse INT AUTO_INCREMENT NOT NULL, id_reclamation INT DEFAULT NULL, reponse VARCHAR(50) NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_C7CB5101D672A9F3 (id_reclamation), PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_role INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_role INT DEFAULT NULL, nom_societe INT NOT NULL, biographie VARCHAR(70) NOT NULL, username VARCHAR(50) NOT NULL, address VARCHAR(70) NOT NULL, mot_de_passe VARCHAR(50) NOT NULL, email VARCHAR(70) NOT NULL, contact VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B3DC499668 (id_role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E52F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id_quiz)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C9486A13 FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E550EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B828C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E6681A34 FOREIGN KEY (id_demandeur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361050EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B28C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B7BF2A12 FOREIGN KEY (id_file) REFERENCES file (id_file)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id_quiz)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9250EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640450EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A28C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT FK_C7CB5101D672A9F3 FOREIGN KEY (id_reclamation) REFERENCES reclamation (id_reclamation)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (id_role)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E52F32E690');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C9486A13');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E550EAE44');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B828C83A95');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E6681A34');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361050EAE44');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA50EAE44');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B28C83A95');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B50EAE44');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B7BF2A12');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2F32E690');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA9250EAE44');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640450EAE44');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A28C83A95');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B3CA4B');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY FK_C7CB5101D672A9F3');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DC499668');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE reponse_reclamation');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
