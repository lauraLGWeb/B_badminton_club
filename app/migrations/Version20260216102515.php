<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216102515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_player ADD CONSTRAINT FK_58CCE591A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_58CCE591A76ED395 ON internship_player (user_id)');
        $this->addSql('ALTER TABLE user ADD external_member TINYINT(1) NOT NULL, ADD phone_nbr VARCHAR(13) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_player DROP FOREIGN KEY FK_58CCE591A76ED395');
        $this->addSql('DROP INDEX IDX_58CCE591A76ED395 ON internship_player');
        $this->addSql('ALTER TABLE user DROP external_member, DROP phone_nbr');
    }
}
