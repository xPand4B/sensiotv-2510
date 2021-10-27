<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211027151042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, firstname, lastname, email, phone, password FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL COLLATE BINARY, lastname VARCHAR(50) NOT NULL COLLATE BINARY, email VARCHAR(200) NOT NULL COLLATE BINARY, phone VARCHAR(20) DEFAULT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB DEFAULT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO users (id, firstname, lastname, email, phone, password) SELECT id, firstname, lastname, email, phone, password FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, firstname, lastname, email, phone, password FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(200) NOT NULL, phone VARCHAR(20) DEFAULT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO users (id, firstname, lastname, email, phone, password) SELECT id, firstname, lastname, email, phone, password FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }
}
