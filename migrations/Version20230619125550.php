<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619125550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url ADD original_url VARCHAR(255) NOT NULL, ADD short_url_code VARCHAR(255) NOT NULL, DROP long_url, DROP short_url');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url ADD long_url VARCHAR(255) NOT NULL, ADD short_url VARCHAR(255) NOT NULL, DROP original_url, DROP short_url_code');
    }
}
