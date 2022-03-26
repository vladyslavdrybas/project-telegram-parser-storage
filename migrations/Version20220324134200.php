<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324134200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );
        if (!$schema->hasTable('channel')) {
            $this->addSql('CREATE TABLE channel (id UUID NOT NULL, title TEXT NOT NULL, main_link TEXT NOT NULL, message_link TEXT NOT NULL, active BOOLEAN DEFAULT \'true\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE UNIQUE INDEX uniq_a2f98e472b36786b ON channel (title)');
            $this->addSql('COMMENT ON COLUMN channel.id IS \'(DC2Type:uuid)\'');
            $this->abortIf(
                !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
                "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
            );
        }

        if (!$schema->hasTable('evil_channel')) {
            $this->addSql('CREATE TABLE evil_channel (id UUID NOT NULL, platform VARCHAR(255) NOT NULL, link TEXT NOT NULL, post_id TEXT NOT NULL, meta TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE UNIQUE INDEX uniq_f985a89e36ac99f14b89032c ON evil_channel (link, post_id)');
            $this->addSql('COMMENT ON COLUMN evil_channel.id IS \'(DC2Type:uuid)\'');
            $this->abortIf(
                !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
                "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
            );
        }

        if (!$schema->hasTable('post')) {
            $this->addSql('CREATE TABLE post (id UUID NOT NULL, channel TEXT NOT NULL, post_number INT NOT NULL, meta TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
            $this->addSql('CREATE UNIQUE INDEX uniq_5a8a6c8da2f98e47a6b2fb31 ON post (channel, post_number)');
            $this->addSql('COMMENT ON COLUMN post.id IS \'(DC2Type:uuid)\'');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE channel');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE evil_channel');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL100Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL100Platform'."
        );

        $this->addSql('DROP TABLE post');
    }
}
