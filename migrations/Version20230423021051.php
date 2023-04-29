<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423021051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY fk22');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY annonce_ibfk_1');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY annonce_ibfk_2');
        $this->addSql('ALTER TABLE annonce CHANGE id_categorie id_categorie INT DEFAULT NULL, CHANGE id_quiz id_quiz INT DEFAULT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE description description VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E52F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id_quiz)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5C9486A13 FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E550EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE annonce RENAME INDEX id_quiz TO IDX_F65593E52F32E690');
        $this->addSql('ALTER TABLE annonce RENAME INDEX fk22 TO IDX_F65593E5C9486A13');
        $this->addSql('ALTER TABLE annonce RENAME INDEX id_utilisateur TO IDX_F65593E550EAE44');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_1');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY candidature_ibfk_2');
        $this->addSql('ALTER TABLE candidature CHANGE id_annonce id_annonce INT DEFAULT NULL, CHANGE id_demandeur id_demandeur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B828C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E6681A34 FOREIGN KEY (id_demandeur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE candidature RENAME INDEX id_annonce TO IDX_E33BD3B828C83A95');
        $this->addSql('ALTER TABLE candidature RENAME INDEX id_demandeur TO IDX_E33BD3B8E6681A34');
        $this->addSql('ALTER TABLE file DROP INDEX id_utilisateur, ADD UNIQUE INDEX UNIQ_8C9F361050EAE44 (id_utilisateur)');
        $this->addSql('ALTER TABLE file CHANGE id_file id_file VARCHAR(255) NOT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE cv cv LONGBLOB DEFAULT NULL, CHANGE deplome deplome LONGBLOB DEFAULT NULL, CHANGE lettermotivation lettermotivation LONGBLOB DEFAULT NULL, CHANGE nameCv namecv VARCHAR(255) NOT NULL, CHANGE nameDeplome namedeplome VARCHAR(255) NOT NULL, CHANGE nameMotivation namemotivation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY notification_ibfk_1');
        $this->addSql('ALTER TABLE notification CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification RENAME INDEX id_utilisateur TO IDX_BF5476CA50EAE44');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY postulation_ibfk_3');
        $this->addSql('ALTER TABLE postulation CHANGE id id VARCHAR(255) NOT NULL, CHANGE id_annonce id_annonce INT DEFAULT NULL, CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE id_file id_file VARCHAR(255) DEFAULT NULL, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B7BF2A12 FOREIGN KEY (id_file) REFERENCES file (id_file)');
        $this->addSql('ALTER TABLE postulation RENAME INDEX id_annonce TO IDX_DA7D4E9B28C83A95');
        $this->addSql('ALTER TABLE postulation RENAME INDEX id_utilisateur TO IDX_DA7D4E9B50EAE44');
        $this->addSql('ALTER TABLE postulation RENAME INDEX id_file TO IDX_DA7D4E9B7BF2A12');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY question_ibfk_1');
        $this->addSql('ALTER TABLE question CHANGE id_BonneReponse id_bonnereponse VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E2F32E690 FOREIGN KEY (id_quiz) REFERENCES quiz (id_quiz)');
        $this->addSql('ALTER TABLE question RENAME INDEX id_quiz TO IDX_B6F7494E2F32E690');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY quiz_ibfk_1');
        $this->addSql('ALTER TABLE quiz CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE barem barem VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9250EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE quiz RENAME INDEX id_utilisateur TO IDX_A412FA9250EAE44');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reclamation CHANGE id_utilisateur id_utilisateur INT DEFAULT NULL, CHANGE titre titre VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE60640450EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation RENAME INDEX reclamation_ibfk_1 TO IDX_CE60640450EAE44');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY fk1');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY rendez_vous_ibfk_1');
        $this->addSql('ALTER TABLE rendez_vous CHANGE id_rendez_vous id_rendez_vous VARCHAR(255) NOT NULL, CHANGE id_user id_user INT DEFAULT NULL, CHANGE id_annonce id_annonce INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A28C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B3CA4B FOREIGN KEY (id_user) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous RENAME INDEX fk1 TO IDX_65E8AA0A28C83A95');
        $this->addSql('ALTER TABLE rendez_vous RENAME INDEX id_user TO IDX_65E8AA0A6B3CA4B');
        $this->addSql('ALTER TABLE reponse_reclamation DROP INDEX fk2, ADD UNIQUE INDEX UNIQ_C7CB5101D672A9F3 (id_reclamation)');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY fk2');
        $this->addSql('ALTER TABLE reponse_reclamation CHANGE id_reclamation id_reclamation INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT FK_C7CB5101D672A9F3 FOREIGN KEY (id_reclamation) REFERENCES reclamation (id_reclamation)');
        $this->addSql('ALTER TABLE role CHANGE nom_role nom_role VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY fk');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom_societe nom_societe INT NOT NULL, CHANGE biographie biographie VARCHAR(70) NOT NULL, CHANGE address address VARCHAR(70) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (id_role)');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX fk TO IDX_1D1C63B3DC499668');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E52F32E690');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5C9486A13');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E550EAE44');
        $this->addSql('ALTER TABLE annonce CHANGE id_quiz id_quiz INT NOT NULL, CHANGE id_categorie id_categorie INT NOT NULL, CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE description description TEXT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT fk22 FOREIGN KEY (id_categorie) REFERENCES categorie (id_categorie) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT annonce_ibfk_1 FOREIGN KEY (id_quiz) REFERENCES quiz (id_Quiz) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT annonce_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce RENAME INDEX idx_f65593e550eae44 TO id_utilisateur');
        $this->addSql('ALTER TABLE annonce RENAME INDEX idx_f65593e5c9486a13 TO fk22');
        $this->addSql('ALTER TABLE annonce RENAME INDEX idx_f65593e52f32e690 TO id_quiz');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B828C83A95');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E6681A34');
        $this->addSql('ALTER TABLE candidature CHANGE id_annonce id_annonce INT NOT NULL, CHANGE id_demandeur id_demandeur INT NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_1 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT candidature_ibfk_2 FOREIGN KEY (id_demandeur) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidature RENAME INDEX idx_e33bd3b828c83a95 TO id_annonce');
        $this->addSql('ALTER TABLE candidature RENAME INDEX idx_e33bd3b8e6681a34 TO id_demandeur');
        $this->addSql('ALTER TABLE file DROP INDEX UNIQ_8C9F361050EAE44, ADD INDEX id_utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE file CHANGE id_file id_file INT AUTO_INCREMENT NOT NULL, CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE cv cv BLOB DEFAULT NULL, CHANGE deplome deplome BLOB DEFAULT NULL, CHANGE lettermotivation lettermotivation BLOB DEFAULT NULL, CHANGE namecv nameCv VARCHAR(255) DEFAULT \'NULL\', CHANGE namedeplome nameDeplome VARCHAR(255) DEFAULT \'NULL\', CHANGE namemotivation nameMotivation VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA50EAE44');
        $this->addSql('ALTER TABLE notification CHANGE id_utilisateur id_utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT notification_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification RENAME INDEX idx_bf5476ca50eae44 TO id_utilisateur');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B7BF2A12');
        $this->addSql('ALTER TABLE postulation CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE id_annonce id_annonce INT NOT NULL, CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE id_file id_file INT NOT NULL, CHANGE date date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT postulation_ibfk_3 FOREIGN KEY (id_file) REFERENCES file (id_file) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postulation RENAME INDEX idx_da7d4e9b50eae44 TO id_utilisateur');
        $this->addSql('ALTER TABLE postulation RENAME INDEX idx_da7d4e9b7bf2a12 TO id_file');
        $this->addSql('ALTER TABLE postulation RENAME INDEX idx_da7d4e9b28c83a95 TO id_annonce');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E2F32E690');
        $this->addSql('ALTER TABLE question CHANGE id_bonnereponse id_BonneReponse CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT question_ibfk_1 FOREIGN KEY (id_Quiz) REFERENCES quiz (id_Quiz) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_b6f7494e2f32e690 TO id_Quiz');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA9250EAE44');
        $this->addSql('ALTER TABLE quiz CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE barem barem VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT quiz_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz RENAME INDEX idx_a412fa9250eae44 TO id_utilisateur');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE60640450EAE44');
        $this->addSql('ALTER TABLE reclamation CHANGE id_utilisateur id_utilisateur INT NOT NULL, CHANGE titre titre VARCHAR(30) NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE statut statut VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation RENAME INDEX idx_ce60640450eae44 TO reclamation_ibfk_1');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A28C83A95');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A6B3CA4B');
        $this->addSql('ALTER TABLE rendez_vous CHANGE id_rendez_vous id_rendez_vous INT AUTO_INCREMENT NOT NULL, CHANGE id_annonce id_annonce INT NOT NULL, CHANGE id_user id_user INT NOT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT fk1 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT rendez_vous_ibfk_1 FOREIGN KEY (id_user) REFERENCES utilisateur (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendez_vous RENAME INDEX idx_65e8aa0a28c83a95 TO fk1');
        $this->addSql('ALTER TABLE rendez_vous RENAME INDEX idx_65e8aa0a6b3ca4b TO id_user');
        $this->addSql('ALTER TABLE reponse_reclamation DROP INDEX UNIQ_C7CB5101D672A9F3, ADD INDEX fk2 (id_reclamation)');
        $this->addSql('ALTER TABLE reponse_reclamation DROP FOREIGN KEY FK_C7CB5101D672A9F3');
        $this->addSql('ALTER TABLE reponse_reclamation CHANGE id_reclamation id_reclamation INT NOT NULL');
        $this->addSql('ALTER TABLE reponse_reclamation ADD CONSTRAINT fk2 FOREIGN KEY (id_reclamation) REFERENCES reclamation (id_reclamation) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role CHANGE nom_role nom_role VARCHAR(50) DEFAULT \'NULL\', CHANGE description description VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DC499668');
        $this->addSql('ALTER TABLE utilisateur CHANGE nom_societe nom_societe VARCHAR(70) DEFAULT \'NULL\', CHANGE biographie biographie VARCHAR(70) DEFAULT \'NULL\', CHANGE address address VARCHAR(70) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT fk FOREIGN KEY (id_role) REFERENCES role (id_role) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur RENAME INDEX idx_1d1c63b3dc499668 TO fk');
    }
}
