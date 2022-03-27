<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327152028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD channel_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE post ALTER channel TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE post ALTER channel DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN post.channel_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D72F5A1AA ON post (channel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D72F5A1AA');
        $this->addSql('DROP INDEX IDX_5A8A6C8D72F5A1AA');
        $this->addSql('ALTER TABLE post DROP channel_id');
        $this->addSql('ALTER TABLE post ALTER channel TYPE TEXT');
        $this->addSql('ALTER TABLE post ALTER channel DROP DEFAULT');
    }
}
