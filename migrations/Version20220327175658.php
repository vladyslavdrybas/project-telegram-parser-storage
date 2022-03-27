<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327175658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE miner (id UUID NOT NULL, title TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_56695B02B36786B ON miner (title)');
        $this->addSql('COMMENT ON COLUMN miner.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE miner_post_queue (miner_id UUID NOT NULL, post_id UUID NOT NULL, PRIMARY KEY(miner_id, post_id))');
        $this->addSql('CREATE INDEX IDX_943DC890BF88117 ON miner_post_queue (miner_id)');
        $this->addSql('CREATE INDEX IDX_943DC8904B89032C ON miner_post_queue (post_id)');
        $this->addSql('COMMENT ON COLUMN miner_post_queue.miner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN miner_post_queue.post_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE miner_post_archive (miner_id UUID NOT NULL, post_id UUID NOT NULL, PRIMARY KEY(miner_id, post_id))');
        $this->addSql('CREATE INDEX IDX_BF68220DBF88117 ON miner_post_archive (miner_id)');
        $this->addSql('CREATE INDEX IDX_BF68220D4B89032C ON miner_post_archive (post_id)');
        $this->addSql('COMMENT ON COLUMN miner_post_archive.miner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN miner_post_archive.post_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE miner_channel (miner_id UUID NOT NULL, channel_id UUID NOT NULL, PRIMARY KEY(miner_id, channel_id))');
        $this->addSql('CREATE INDEX IDX_ABFA8331BF88117 ON miner_channel (miner_id)');
        $this->addSql('CREATE INDEX IDX_ABFA833172F5A1AA ON miner_channel (channel_id)');
        $this->addSql('COMMENT ON COLUMN miner_channel.miner_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN miner_channel.channel_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE miner_post_queue ADD CONSTRAINT FK_943DC890BF88117 FOREIGN KEY (miner_id) REFERENCES miner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE miner_post_queue ADD CONSTRAINT FK_943DC8904B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE miner_post_archive ADD CONSTRAINT FK_BF68220DBF88117 FOREIGN KEY (miner_id) REFERENCES miner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE miner_post_archive ADD CONSTRAINT FK_BF68220D4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE miner_channel ADD CONSTRAINT FK_ABFA8331BF88117 FOREIGN KEY (miner_id) REFERENCES miner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE miner_channel ADD CONSTRAINT FK_ABFA833172F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE miner_post_queue DROP CONSTRAINT FK_943DC890BF88117');
        $this->addSql('ALTER TABLE miner_post_archive DROP CONSTRAINT FK_BF68220DBF88117');
        $this->addSql('ALTER TABLE miner_channel DROP CONSTRAINT FK_ABFA8331BF88117');
        $this->addSql('DROP TABLE miner');
        $this->addSql('DROP TABLE miner_post_queue');
        $this->addSql('DROP TABLE miner_post_archive');
        $this->addSql('DROP TABLE miner_channel');
    }
}
