<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106195332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventorie (id INT AUTO_INCREMENT NOT NULL, reference_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_6A13D0D81645DEA9 (reference_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventorie_channel (inventorie_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_FE4A1E0FE05D2513 (inventorie_id), INDEX IDX_FE4A1E0F72F5A1AA (channel_id), PRIMARY KEY(inventorie_id, channel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventorie ADD CONSTRAINT FK_6A13D0D81645DEA9 FOREIGN KEY (reference_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE inventorie_channel ADD CONSTRAINT FK_FE4A1E0FE05D2513 FOREIGN KEY (inventorie_id) REFERENCES inventorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventorie_channel ADD CONSTRAINT FK_FE4A1E0F72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADAEA34913 ON product (reference)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventorie DROP FOREIGN KEY FK_6A13D0D81645DEA9');
        $this->addSql('ALTER TABLE inventorie_channel DROP FOREIGN KEY FK_FE4A1E0FE05D2513');
        $this->addSql('ALTER TABLE inventorie_channel DROP FOREIGN KEY FK_FE4A1E0F72F5A1AA');
        $this->addSql('DROP TABLE inventorie');
        $this->addSql('DROP TABLE inventorie_channel');
        $this->addSql('DROP INDEX UNIQ_D34A04ADAEA34913 ON product');
    }
}
