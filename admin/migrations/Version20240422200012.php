<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422200012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD ville VARCHAR(20) NOT NULL, ADD phone_number VARCHAR(15) DEFAULT NULL, ADD genre VARCHAR(20) DEFAULT NULL, DROP numtele, CHANGE email email VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(512) DEFAULT NULL, CHANGE date_creation date_creation DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD numtele VARCHAR(10) NOT NULL, DROP ville, DROP phone_number, DROP genre, CHANGE email email VARCHAR(70) NOT NULL, CHANGE password password VARCHAR(50) NOT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE date_creation date_creation DATE NOT NULL');
    }
}
