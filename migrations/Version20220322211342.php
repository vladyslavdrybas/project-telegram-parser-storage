<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322211342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evil_channel (id UUID NOT NULL, platform VARCHAR(255) NOT NULL, link TEXT NOT NULL, post_id TEXT NOT NULL, meta TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F985A89E36AC99F14B89032C ON evil_channel (link, post_id)');
        $this->addSql('COMMENT ON COLUMN evil_channel.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE post (id UUID NOT NULL, channel TEXT NOT NULL, post_number INT NOT NULL, meta TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DA2F98E47A6B2FB31 ON post (channel, post_number)');
        $this->addSql('COMMENT ON COLUMN post.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE evil_channel');
        $this->addSql('DROP TABLE post');
    }
}
