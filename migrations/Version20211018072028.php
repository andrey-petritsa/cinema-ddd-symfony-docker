<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018072028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie CHANGE id id BINARY(16) NOT NULL, CHANGE duration duration VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\'');
        $this->addSql('ALTER TABLE session CHANGE id id BINARY(16) NOT NULL, CHANGE movie_id movie_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE id id BINARY(16) NOT NULL, CHANGE session_id session_id BINARY(16) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie CHANGE id id BINARY(16) NOT NULL, CHANGE duration duration DATETIME NOT NULL');
        $this->addSql('ALTER TABLE session CHANGE id id BINARY(16) NOT NULL, CHANGE movie_id movie_id BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket CHANGE id id BINARY(16) NOT NULL, CHANGE session_id session_id BINARY(16) DEFAULT NULL');
    }
}
