<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526092128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_tutoriel_id INT NOT NULL, date_finish DATETIME NOT NULL, INDEX IDX_EDBFD5EC79F37AE5 (id_user_id), INDEX IDX_EDBFD5EC64A4004C (id_tutoriel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC64A4004C FOREIGN KEY (id_tutoriel_id) REFERENCES tutoriel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC79F37AE5');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC64A4004C');
        $this->addSql('DROP TABLE historique');
    }
}
