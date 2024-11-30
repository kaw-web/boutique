<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106195818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inbounds (id INT AUTO_INCREMENT NOT NULL, inventories_id INT DEFAULT NULL, arrival_date DATETIME NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_F964252D632FA1DE (inventories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inbounds ADD CONSTRAINT FK_F964252D632FA1DE FOREIGN KEY (inventories_id) REFERENCES inventorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inbounds DROP FOREIGN KEY FK_F964252D632FA1DE');
        $this->addSql('DROP TABLE inbounds');
    }
}
