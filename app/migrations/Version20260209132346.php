<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260209132346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_player ADD CONSTRAINT FK_58CCE5917A4A70BE FOREIGN KEY (internship_id) REFERENCES internships (id)');
        $this->addSql('CREATE INDEX IDX_58CCE5917A4A70BE ON internship_player (internship_id)');
        $this->addSql('ALTER TABLE internships DROP hour, CHANGE date date_time DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internships ADD hour TIME NOT NULL, CHANGE date_time date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE internship_player DROP FOREIGN KEY FK_58CCE5917A4A70BE');
        $this->addSql('DROP INDEX IDX_58CCE5917A4A70BE ON internship_player');
    }
}
