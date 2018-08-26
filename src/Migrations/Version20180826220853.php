<?php

declare(strict_types=1);

namespace Mdojr\EmailProvider\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @codeCoverageIgnore
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180826220853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, is_active TINYINT(1) DEFAULT \'1\' NOT NULL, UNIQUE INDEX username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE virtual_aliases (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT NULL, source VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, destination VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX domain_id (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE virtual_domains (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE virtual_users (id INT AUTO_INCREMENT NOT NULL, domain_id INT DEFAULT NULL, password VARCHAR(106) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(120) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX email (email), INDEX domain_id (domain_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE admin');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE virtual_aliases');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE virtual_domains');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE virtual_users');
    }
}
