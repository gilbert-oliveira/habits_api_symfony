<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204141028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habit (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habit_day (habit_id INT NOT NULL, day_id INT NOT NULL, INDEX IDX_ABFC3D10E7AEB3B2 (habit_id), INDEX IDX_ABFC3D109C24126 (day_id), PRIMARY KEY(habit_id, day_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE week_day (id INT AUTO_INCREMENT NOT NULL, habit_id INT NOT NULL, week_day INT NOT NULL, INDEX IDX_256D1361E7AEB3B2 (habit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE habit_day ADD CONSTRAINT FK_ABFC3D10E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habit_day ADD CONSTRAINT FK_ABFC3D109C24126 FOREIGN KEY (day_id) REFERENCES day (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE week_day ADD CONSTRAINT FK_256D1361E7AEB3B2 FOREIGN KEY (habit_id) REFERENCES habit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habit_day DROP FOREIGN KEY FK_ABFC3D10E7AEB3B2');
        $this->addSql('ALTER TABLE habit_day DROP FOREIGN KEY FK_ABFC3D109C24126');
        $this->addSql('ALTER TABLE week_day DROP FOREIGN KEY FK_256D1361E7AEB3B2');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE habit');
        $this->addSql('DROP TABLE habit_day');
        $this->addSql('DROP TABLE week_day');
    }
}
