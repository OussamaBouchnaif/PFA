<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513180816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F82EA2E54');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E82EA2E54');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D294102D4');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B82EA2E54');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74BB47685CD');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE ligne_commande');
        $this->addSql('ALTER TABLE avis_camera ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE blog CHANGE contenu contenu VARCHAR(255) NOT NULL, CHANGE image_coverture image_coverture VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_FE86641082EA2E54 ON facture');
        $this->addSql('ALTER TABLE facture ADD cart_id INT DEFAULT NULL, DROP commande_id');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE8664101AD5CDBF ON facture (cart_id)');
        $this->addSql('DROP INDEX UNIQ_A60C9F1F82EA2E54 ON livraison');
        $this->addSql('ALTER TABLE livraison ADD cart_id INT DEFAULT NULL, DROP commande_id');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A60C9F1F1AD5CDBF ON livraison (cart_id)');
        $this->addSql('DROP INDEX UNIQ_B1DC7A1E82EA2E54 ON paiement');
        $this->addSql('ALTER TABLE paiement ADD cart_id INT DEFAULT NULL, DROP commande_id');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1DC7A1E1AD5CDBF ON paiement (cart_id)');
        $this->addSql('ALTER TABLE reduction DROP prix');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(100) DEFAULT NULL, CHANGE date_creation date_creation DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, code_promo_id INT NOT NULL, date_commande DATE NOT NULL, status VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, total DOUBLE PRECISION NOT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D294102D4 (code_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ligne_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, camera_id INT NOT NULL, qte SMALLINT NOT NULL, prix_initial DOUBLE PRECISION NOT NULL, prix_promo DOUBLE PRECISION NOT NULL, INDEX IDX_3170B74BB47685CD (camera_id), INDEX IDX_3170B74B82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74BB47685CD FOREIGN KEY (camera_id) REFERENCES camera (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE avis_camera DROP created_at');
        $this->addSql('ALTER TABLE blog CHANGE contenu contenu LONGTEXT NOT NULL, CHANGE image_coverture image_coverture VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_FE8664101AD5CDBF ON facture');
        $this->addSql('ALTER TABLE facture ADD commande_id INT NOT NULL, DROP cart_id');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FE86641082EA2E54 ON facture (commande_id)');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F1AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_A60C9F1F1AD5CDBF ON livraison');
        $this->addSql('ALTER TABLE livraison ADD commande_id INT NOT NULL, DROP cart_id');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A60C9F1F82EA2E54 ON livraison (commande_id)');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E1AD5CDBF');
        $this->addSql('DROP INDEX UNIQ_B1DC7A1E1AD5CDBF ON paiement');
        $this->addSql('ALTER TABLE paiement ADD commande_id INT NOT NULL, DROP cart_id');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1DC7A1E82EA2E54 ON paiement (commande_id)');
        $this->addSql('ALTER TABLE reduction ADD prix DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE image image VARCHAR(512) DEFAULT NULL, CHANGE date_creation date_creation DATETIME NOT NULL');
    }
}
