<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026194024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9545317D1');
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9B6E62EFA');
        $this->addSql('ALTER TABLE vehicle_attribute ADD id INT AUTO_INCREMENT NOT NULL, ADD value VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id)');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle_attribute MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9545317D1');
        $this->addSql('ALTER TABLE vehicle_attribute DROP FOREIGN KEY FK_DC5AAA9B6E62EFA');
        $this->addSql('ALTER TABLE vehicle_attribute DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE vehicle_attribute DROP id, DROP value');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_attribute ADD CONSTRAINT FK_DC5AAA9B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attributes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicle_attribute ADD PRIMARY KEY (vehicle_id, attribute_id)');
    }
}
