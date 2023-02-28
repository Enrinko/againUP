<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228094453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tests_of_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tests_id INT NOT NULL, INDEX IDX_AD45C5E6A76ED395 (user_id), INDEX IDX_AD45C5E6F5D80971 (tests_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tests_of_user ADD CONSTRAINT FK_AD45C5E6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tests_of_user ADD CONSTRAINT FK_AD45C5E6F5D80971 FOREIGN KEY (tests_id) REFERENCES tests (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tests_of_user DROP FOREIGN KEY FK_AD45C5E6A76ED395');
        $this->addSql('ALTER TABLE tests_of_user DROP FOREIGN KEY FK_AD45C5E6F5D80971');
        $this->addSql('DROP TABLE tests_of_user');
    }
}
