<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430171851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis_camera (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, camera_id INT NOT NULL, note SMALLINT NOT NULL, commentaire VARCHAR(400) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8CD67ABF19EB6921 (client_id), INDEX IDX_8CD67ABFB47685CD (camera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, image_coverture VARCHAR(255) NOT NULL, INDEX IDX_C0155143A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_camera (blog_id INT NOT NULL, camera_id INT NOT NULL, INDEX IDX_AE534BC4DAE07E97 (blog_id), INDEX IDX_AE534BC4B47685CD (camera_id), PRIMARY KEY(blog_id, camera_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camera (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(400) NOT NULL, prix DOUBLE PRECISION NOT NULL, stock SMALLINT NOT NULL, date_ajout DATE NOT NULL, status VARCHAR(50) DEFAULT NULL, couleur VARCHAR(40) NOT NULL, vision_noctrune TINYINT(1) NOT NULL, poids DOUBLE PRECISION NOT NULL, materiaux VARCHAR(200) NOT NULL, resolution VARCHAR(40) NOT NULL, angle_vision VARCHAR(20) NOT NULL, connectivite TINYINT(1) NOT NULL, stockage DOUBLE PRECISION NOT NULL, alimentation VARCHAR(40) NOT NULL, INDEX IDX_3B1CEE05BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, code_promo_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_BA388B719EB6921 (client_id), INDEX IDX_BA388B7294102D4 (code_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, camera_id INT DEFAULT NULL, cart_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, stockage VARCHAR(15) DEFAULT NULL, INDEX IDX_F0FE2527B47685CD (camera_id), INDEX IDX_F0FE25271AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, ville VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, phone_number VARCHAR(15) DEFAULT NULL, genre VARCHAR(20) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, date_inscription DATE NOT NULL, status_compte VARCHAR(20) NOT NULL, pts_fidelite SMALLINT DEFAULT NULL, address_liv_sup VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(10) NOT NULL, description VARCHAR(200) DEFAULT NULL, pourcentage SMALLINT NOT NULL, date_expiration DATE NOT NULL, nombre_autorisation SMALLINT NOT NULL, status VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, date_facture DATE NOT NULL, detail VARCHAR(200) NOT NULL, status VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_FE8664101AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorit_camera (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, camera_id INT DEFAULT NULL, date_ajout DATE NOT NULL, INDEX IDX_BBFD3A119EB6921 (client_id), INDEX IDX_BBFD3A1B47685CD (camera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_camera (id INT AUTO_INCREMENT NOT NULL, camera_id INT NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_9401B0CDB47685CD (camera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_reduction (id INT AUTO_INCREMENT NOT NULL, reduction_id INT NOT NULL, camera_id INT NOT NULL, INDEX IDX_7E025BE0C03CB092 (reduction_id), INDEX IDX_7E025BE0B47685CD (camera_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, date_expedition DATE NOT NULL, date_estime DATE NOT NULL, status_liv VARCHAR(100) NOT NULL, info_suivi VARCHAR(100) NOT NULL, mode_livraison VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_A60C9F1F1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, methode VARCHAR(100) NOT NULL, date_paiement DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, status VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1E1AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reduction (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(300) NOT NULL, poucentage SMALLINT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, ville VARCHAR(20) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, phone_number VARCHAR(15) DEFAULT NULL, genre VARCHAR(20) DEFAULT NULL, image VARCHAR(100) DEFAULT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis_camera ADD CONSTRAINT FK_8CD67ABF19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE avis_camera ADD CONSTRAINT FK_8CD67ABFB47685CD FOREIGN KEY (camera_id) REFERENCES camera (id)');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_camera ADD CONSTRAINT FK_AE534BC4DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_camera ADD CONSTRAINT FK_AE534BC4B47685CD FOREIGN KEY (camera_id) REFERENCES camera (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camera ADD CONSTRAINT FK_3B1CEE05BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE2527B47685CD FOREIGN KEY (camera_id) REFERENCES camera (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664101AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE favorit_camera ADD CONSTRAINT FK_BBFD3A119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE favorit_camera ADD CONSTRAINT FK_BBFD3A1B47685CD FOREIGN KEY (camera_id) REFERENCES camera (id)');
        $this->addSql('ALTER TABLE image_camera ADD CONSTRAINT FK_9401B0CDB47685CD FOREIGN KEY (camera_id) REFERENCES camera (id)');
        $this->addSql('ALTER TABLE ligne_reduction ADD CONSTRAINT FK_7E025BE0C03CB092 FOREIGN KEY (reduction_id) REFERENCES reduction (id)');
        $this->addSql('ALTER TABLE ligne_reduction ADD CONSTRAINT FK_7E025BE0B47685CD FOREIGN KEY (camera_id) REFERENCES camera (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E1AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_camera DROP FOREIGN KEY FK_8CD67ABF19EB6921');
        $this->addSql('ALTER TABLE avis_camera DROP FOREIGN KEY FK_8CD67ABFB47685CD');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143A76ED395');
        $this->addSql('ALTER TABLE blog_camera DROP FOREIGN KEY FK_AE534BC4DAE07E97');
        $this->addSql('ALTER TABLE blog_camera DROP FOREIGN KEY FK_AE534BC4B47685CD');
        $this->addSql('ALTER TABLE camera DROP FOREIGN KEY FK_3B1CEE05BCF5E72D');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B719EB6921');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7294102D4');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE2527B47685CD');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664101AD5CDBF');
        $this->addSql('ALTER TABLE favorit_camera DROP FOREIGN KEY FK_BBFD3A119EB6921');
        $this->addSql('ALTER TABLE favorit_camera DROP FOREIGN KEY FK_BBFD3A1B47685CD');
        $this->addSql('ALTER TABLE image_camera DROP FOREIGN KEY FK_9401B0CDB47685CD');
        $this->addSql('ALTER TABLE ligne_reduction DROP FOREIGN KEY FK_7E025BE0C03CB092');
        $this->addSql('ALTER TABLE ligne_reduction DROP FOREIGN KEY FK_7E025BE0B47685CD');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F1AD5CDBF');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E1AD5CDBF');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE avis_camera');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_camera');
        $this->addSql('DROP TABLE camera');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE favorit_camera');
        $this->addSql('DROP TABLE image_camera');
        $this->addSql('DROP TABLE ligne_reduction');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE reduction');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
