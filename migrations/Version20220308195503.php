<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308195503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE celebrity (id UUID NOT NULL, title VARCHAR(255) NOT NULL, platform VARCHAR(255) NOT NULL, link TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN celebrity.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE evil_channels ALTER link TYPE TEXT');
        $this->addSql('ALTER TABLE evil_channels ALTER link DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE celebrity');
        $this->addSql('ALTER TABLE evil_channels ALTER link TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE evil_channels ALTER link DROP DEFAULT');
    }
}
