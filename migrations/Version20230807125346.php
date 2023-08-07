<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230807125346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tutoriel_categorie (tutoriel_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_A71370FA7CB6CDBB (tutoriel_id), INDEX IDX_A71370FABCF5E72D (categorie_id), PRIMARY KEY(tutoriel_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tutoriel_categorie ADD CONSTRAINT FK_A71370FA7CB6CDBB FOREIGN KEY (tutoriel_id) REFERENCES tutoriel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutoriel_categorie ADD CONSTRAINT FK_A71370FABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutoriel DROP FOREIGN KEY FK_A2073AEDA21214B7');
        $this->addSql('DROP INDEX IDX_A2073AEDA21214B7 ON tutoriel');
        $this->addSql('ALTER TABLE tutoriel DROP categories_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutoriel_categorie DROP FOREIGN KEY FK_A71370FA7CB6CDBB');
        $this->addSql('ALTER TABLE tutoriel_categorie DROP FOREIGN KEY FK_A71370FABCF5E72D');
        $this->addSql('DROP TABLE tutoriel_categorie');
        $this->addSql('ALTER TABLE tutoriel ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tutoriel ADD CONSTRAINT FK_A2073AEDA21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_A2073AEDA21214B7 ON tutoriel (categories_id)');
    }
}
