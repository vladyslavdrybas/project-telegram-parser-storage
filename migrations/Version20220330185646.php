<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330185646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE source (id UUID NOT NULL, title TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F8A7F732B36786B ON source (title)');
        $this->addSql('COMMENT ON COLUMN source.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE channel ADD source_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN channel.source_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E47953C1C61 FOREIGN KEY (source_id) REFERENCES source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A2F98E47953C1C61 ON channel (source_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E47953C1C61');
        $this->addSql('DROP TABLE source');
        $this->addSql('DROP INDEX IDX_A2F98E47953C1C61');
        $this->addSql('ALTER TABLE channel DROP source_id');
    }
}
