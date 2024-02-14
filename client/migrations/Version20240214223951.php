<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214223951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, image_coverture VARCHAR(255) NOT NULL, INDEX IDX_C0155143A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_camera (blog_id INT NOT NULL, camera_id INT NOT NULL, INDEX IDX_AE534BC4DAE07E97 (blog_id), INDEX IDX_AE534BC4B47685CD (camera_id), PRIMARY KEY(blog_id, camera_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_camera ADD CONSTRAINT FK_AE534BC4DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_camera ADD CONSTRAINT FK_AE534BC4B47685CD FOREIGN KEY (camera_id) REFERENCES camera (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camera ADD couleur VARCHAR(40) NOT NULL, ADD vision_noctrune TINYINT(1) NOT NULL, ADD poids DOUBLE PRECISION NOT NULL, ADD materiaux VARCHAR(200) NOT NULL, ADD resolution VARCHAR(40) NOT NULL, ADD angle_vision VARCHAR(20) NOT NULL, ADD connectivite TINYINT(1) NOT NULL, ADD stockage DOUBLE PRECISION NOT NULL, ADD alimentation VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143A76ED395');
        $this->addSql('ALTER TABLE blog_camera DROP FOREIGN KEY FK_AE534BC4DAE07E97');
        $this->addSql('ALTER TABLE blog_camera DROP FOREIGN KEY FK_AE534BC4B47685CD');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_camera');
        $this->addSql('ALTER TABLE camera DROP couleur, DROP vision_noctrune, DROP poids, DROP materiaux, DROP resolution, DROP angle_vision, DROP connectivite, DROP stockage, DROP alimentation');
    }
}
