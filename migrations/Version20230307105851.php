<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307105851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_course DROP FOREIGN KEY FK_27EF1A82A76ED395');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_27EF1A82A76ED395 ON liste_course');
        $this->addSql('ALTER TABLE liste_course CHANGE user_id utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_course ADD CONSTRAINT FK_27EF1A82FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_27EF1A82FB88E14F ON liste_course (utilisateur_id)');
        $this->addSql('ALTER TABLE utilisateur ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP pseudo, DROP mdp');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liste_course DROP FOREIGN KEY FK_27EF1A82FB88E14F');
        $this->addSql('DROP INDEX IDX_27EF1A82FB88E14F ON liste_course');
        $this->addSql('ALTER TABLE liste_course CHANGE utilisateur_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE liste_course ADD CONSTRAINT FK_27EF1A82A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_27EF1A82A76ED395 ON liste_course (user_id)');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD mdp VARCHAR(255) NOT NULL, DROP email, DROP roles, CHANGE password pseudo VARCHAR(255) NOT NULL');
    }
}
