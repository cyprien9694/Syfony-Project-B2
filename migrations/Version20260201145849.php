<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260201145849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD star_id INT NOT NULL, DROP category');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C2C3B70D7 FOREIGN KEY (star_id) REFERENCES star (id)');
        $this->addSql('CREATE INDEX IDX_9474526C2C3B70D7 ON comment (star_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C2C3B70D7');
        $this->addSql('DROP INDEX IDX_9474526C2C3B70D7 ON comment');
        $this->addSql('ALTER TABLE comment ADD category VARCHAR(50) NOT NULL, DROP star_id');
    }
}
