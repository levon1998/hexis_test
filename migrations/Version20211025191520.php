<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025191520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attributes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicles (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, vendor_id INT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) DEFAULT \'1\' NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1FCE69FA44F5D008 (brand_id), INDEX IDX_1FCE69FAF603EE73 (vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_attribute (vehicle_id INT NOT NULL, attribute_id INT NOT NULL, INDEX IDX_DC5AAA9545317D1 (vehicle_id), INDEX IDX_DC5AAA9B6E62EFA (attribute_id), PRIMARY KEY(vehicle_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicles ADD CONSTRAINT FK_1FCE69FA44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)');
        $this->addSql('ALTER TABLE vehicles ADD CONSTRAINT FK_1FCE69FAF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendors (id)');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9B6E62EFA');
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9545317D1');
        $this->addSql('DROP TABLE attributes');
        $this->addSql('DROP TABLE vehicles');
        $this->addSql('DROP TABLE vehicle_attribute');
    }
}
