<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402231858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B77F2DEE08');
        $this->addSql('DROP INDEX IDX_BA388B77F2DEE08 ON cart');
        $this->addSql('ALTER TABLE cart DROP facture_id');
        $this->addSql('ALTER TABLE facture ADD cart_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE8664101AD5CDBF ON facture (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD facture_id INT NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B77F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BA388B77F2DEE08 ON cart (facture_id)');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_FE8664101AD5CDBF ON facture');
        $this->addSql('ALTER TABLE facture DROP cart_id');
    }
}
