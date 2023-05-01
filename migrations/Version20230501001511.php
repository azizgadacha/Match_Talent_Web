<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501001511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file (id_file VARCHAR(255) NOT NULL, id INT DEFAULT NULL, cv LONGBLOB DEFAULT NULL, deplome LONGBLOB DEFAULT NULL, lettermotivation LONGBLOB DEFAULT NULL, namecv VARCHAR(255) NOT NULL, namedeplome VARCHAR(255) NOT NULL, namemotivation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8C9F3610BF396750 (id), PRIMARY KEY(id_file)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610BF396750 FOREIGN KEY (id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B7BF2A12');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610BF396750');
        $this->addSql('DROP TABLE file');
    }
}
