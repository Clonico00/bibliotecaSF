<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219111104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ejemplar (id INT AUTO_INCREMENT NOT NULL, libro_id INT NOT NULL, estado VARCHAR(255) NOT NULL, estanteria VARCHAR(255) NOT NULL, edicion VARCHAR(255) NOT NULL, INDEX IDX_36B9726C0238522 (libro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE libro (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, autor VARCHAR(255) NOT NULL, editorial VARCHAR(255) NOT NULL, genero VARCHAR(255) NOT NULL, numero_ejemplares INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, socio_id INT NOT NULL, ejemplar_id INT NOT NULL, fecha_devolucion DATE NOT NULL, fecha_retiro DATE NOT NULL, INDEX IDX_F4D874F2DA04E6A9 (socio_id), UNIQUE INDEX UNIQ_F4D874F2BEE15B6C (ejemplar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ejemplar ADD CONSTRAINT FK_36B9726C0238522 FOREIGN KEY (libro_id) REFERENCES libro (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F2BEE15B6C FOREIGN KEY (ejemplar_id) REFERENCES ejemplar (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ejemplar DROP FOREIGN KEY FK_36B9726C0238522');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2DA04E6A9');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F2BEE15B6C');
        $this->addSql('DROP TABLE ejemplar');
        $this->addSql('DROP TABLE libro');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE socio');
    }
}
