<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501001310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('DROP INDEX uniq_8c9f361050eae44 ON file');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F3610BF396750 ON file (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610BF396750');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610BF396750');
        $this->addSql('DROP INDEX uniq_8c9f3610bf396750 ON file');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8C9F361050EAE44 ON file (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610BF396750 FOREIGN KEY (id) REFERENCES user (id)');
    }
}
