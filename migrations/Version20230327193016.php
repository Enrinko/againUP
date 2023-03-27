<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327193016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C606BCB134CE');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F5D80971');
        $this->addSql('ALTER TABLE tests_of_user DROP FOREIGN KEY FK_AD45C5E6A76ED395');
        $this->addSql('ALTER TABLE tests_of_user DROP FOREIGN KEY FK_AD45C5E6F5D80971');
        $this->addSql('DROP TABLE answers');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE tests');
        $this->addSql('DROP TABLE tests_of_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answers (id INT AUTO_INCREMENT NOT NULL, questions_id INT NOT NULL, answer LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_true TINYINT(1) NOT NULL, INDEX IDX_50D0C606BCB134CE (questions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, tests_id INT NOT NULL, question LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8ADC54D5F5D80971 (tests_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tests (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tests_of_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tests_id INT NOT NULL, score INT NOT NULL, INDEX IDX_AD45C5E6A76ED395 (user_id), INDEX IDX_AD45C5E6F5D80971 (tests_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C606BCB134CE FOREIGN KEY (questions_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F5D80971 FOREIGN KEY (tests_id) REFERENCES tests (id)');
        $this->addSql('ALTER TABLE tests_of_user ADD CONSTRAINT FK_AD45C5E6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tests_of_user ADD CONSTRAINT FK_AD45C5E6F5D80971 FOREIGN KEY (tests_id) REFERENCES tests (id)');
    }
}
