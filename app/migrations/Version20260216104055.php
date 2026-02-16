<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260216104055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_player DROP last_name, DROP first_name, DROP email, DROP phone_number');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internship_player ADD last_name VARCHAR(60) NOT NULL, ADD first_name VARCHAR(50) NOT NULL, ADD email VARCHAR(100) NOT NULL, ADD phone_number VARCHAR(15) NOT NULL');
    }
}
