<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307093320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE details_article (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, liste_course_id INT DEFAULT NULL, quantité INT NOT NULL, prix DOUBLE PRECISION NOT NULL, est_acheté TINYINT(1) NOT NULL, INDEX IDX_E46977777294869C (article_id), INDEX IDX_E46977774680FCB (liste_course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_course (id INT AUTO_INCREMENT NOT NULL, utilisateurs_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_27EF1A821E969C5 (utilisateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_article (type_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_2A1B6193C54C8C93 (type_id), INDEX IDX_2A1B61937294869C (article_id), PRIMARY KEY(type_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE details_article ADD CONSTRAINT FK_E46977777294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE details_article ADD CONSTRAINT FK_E46977774680FCB FOREIGN KEY (liste_course_id) REFERENCES liste_course (id)');
        $this->addSql('ALTER TABLE liste_course ADD CONSTRAINT FK_27EF1A821E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE type_article ADD CONSTRAINT FK_2A1B6193C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_article ADD CONSTRAINT FK_2A1B61937294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_article DROP FOREIGN KEY FK_E46977777294869C');
        $this->addSql('ALTER TABLE details_article DROP FOREIGN KEY FK_E46977774680FCB');
        $this->addSql('ALTER TABLE liste_course DROP FOREIGN KEY FK_27EF1A821E969C5');
        $this->addSql('ALTER TABLE type_article DROP FOREIGN KEY FK_2A1B6193C54C8C93');
        $this->addSql('ALTER TABLE type_article DROP FOREIGN KEY FK_2A1B61937294869C');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE details_article');
        $this->addSql('DROP TABLE liste_course');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_article');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
