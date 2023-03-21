<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320230744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id_annonce INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, nom_societé VARCHAR(50) NOT NULL, datedebut DATE NOT NULL, datefin DATE NOT NULL, description VARCHAR(50) NOT NULL, type_contrat VARCHAR(50) NOT NULL, id INT DEFAULT NULL, INDEX IDX_F65593E5BF396750 (id), PRIMARY KEY(id_annonce)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (id_candidature INT AUTO_INCREMENT NOT NULL, id_annonce INT DEFAULT NULL, id_demandeur INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_E33BD3B828C83A95 (id_annonce), INDEX IDX_E33BD3B8E6681A34 (id_demandeur), PRIMARY KEY(id_candidature)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id_categorie INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id_categorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id_file VARCHAR(255) NOT NULL, user_file_id INT DEFAULT NULL, cv LONGBLOB DEFAULT NULL, deplome LONGBLOB DEFAULT NULL, lettermotivation LONGBLOB DEFAULT NULL, namecv VARCHAR(255) NOT NULL, namedeplome VARCHAR(255) NOT NULL, namemotivation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8C9F3610CBC66766 (user_file_id), PRIMARY KEY(id_file)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id_notification INT AUTO_INCREMENT NOT NULL, user_notification_id INT DEFAULT NULL, date DATE NOT NULL, description VARCHAR(150) NOT NULL, INDEX IDX_BF5476CAFDC6F10B (user_notification_id), PRIMARY KEY(id_notification)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id_annonce INT NOT NULL, id INT NOT NULL, id_file VARCHAR(255) DEFAULT NULL, etat VARCHAR(50) NOT NULL, date DATE NOT NULL, INDEX IDX_DA7D4E9B28C83A95 (id_annonce), INDEX IDX_DA7D4E9BBF396750 (id), INDEX IDX_DA7D4E9B7BF2A12 (id_file), PRIMARY KEY(id_annonce, id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_question INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, propositiona VARCHAR(255) NOT NULL, propositionb VARCHAR(255) NOT NULL, propositionc VARCHAR(255) NOT NULL, id_bonnereponse VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E853CD175 (quiz_id), PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id_quiz INT AUTO_INCREMENT NOT NULL, utilisater_id INT DEFAULT NULL, nombre_questions INT NOT NULL, barem VARCHAR(255) NOT NULL, sujet_quiz VARCHAR(255) NOT NULL, INDEX IDX_A412FA929285ADF (utilisater_id), PRIMARY KEY(id_quiz)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id_reclamation INT AUTO_INCREMENT NOT NULL, utilisater_id INT DEFAULT NULL, date DATE NOT NULL, titre VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_CE6064049285ADF (utilisater_id), PRIMARY KEY(id_reclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id_rendez_vous VARCHAR(255) NOT NULL, annonce_id INT DEFAULT NULL, user_rendez_vous_id INT DEFAULT NULL, date_rendez_vous DATE NOT NULL, heure_rendez_vous VARCHAR(30) NOT NULL, INDEX IDX_65E8AA0A8805AB2F (annonce_id), INDEX IDX_65E8AA0AFA6AA1F3 (user_rendez_vous_id), PRIMARY KEY(id_rendez_vous)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_reclamation (id_reponse INT AUTO_INCREMENT NOT NULL, reponse VARCHAR(50) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_role INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, PRIMARY KEY(id_role)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_role INT DEFAULT NULL, nom_societe INT NOT NULL, biographie VARCHAR(70) NOT NULL, username VARCHAR(50) NOT NULL, address VARCHAR(70) NOT NULL, mot_de_passe VARCHAR(50) NOT NULL, email VARCHAR(70) NOT NULL, contact VARCHAR(50) NOT NULL, INDEX IDX_1D1C63B3DC499668 (id_role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B828C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8E6681A34 FOREIGN KEY (id_demandeur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610CBC66766 FOREIGN KEY (user_file_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAFDC6F10B FOREIGN KEY (user_notification_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B28C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B7BF2A12 FOREIGN KEY (id_file) REFERENCES file (idFile)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (idQuiz)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA929285ADF FOREIGN KEY (utilisater_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064049285ADF FOREIGN KEY (utilisater_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (idAnnonce)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AFA6AA1F3 FOREIGN KEY (user_rendez_vous_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DC499668 FOREIGN KEY (id_role) REFERENCES role (idRole)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B828C83A95');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B8E6681A34');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610CBC66766');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAFDC6F10B');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B28C83A95');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BBF396750');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B7BF2A12');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E853CD175');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA929285ADF');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064049285ADF');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0A8805AB2F');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AFA6AA1F3');
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
