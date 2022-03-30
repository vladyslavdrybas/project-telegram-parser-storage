<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330200135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE channel_community_support (id UUID NOT NULL, channel_id UUID DEFAULT NULL, community_id UUID DEFAULT NULL, support_rate INT DEFAULT 0 NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F84B52EB72F5A1AA ON channel_community_support (channel_id)');
        $this->addSql('CREATE INDEX IDX_F84B52EBFDA7B0BF ON channel_community_support (community_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F84B52EB72F5A1AAFDA7B0BF ON channel_community_support (channel_id, community_id)');
        $this->addSql('COMMENT ON COLUMN channel_community_support.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN channel_community_support.channel_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN channel_community_support.community_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE channel_community_support ADD CONSTRAINT FK_F84B52EB72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel_community_support ADD CONSTRAINT FK_F84B52EBFDA7B0BF FOREIGN KEY (community_id) REFERENCES community (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE channel_community_support');
    }
}
