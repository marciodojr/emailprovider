<?php declare(strict_types=1);

namespace Mdojr\EmailProvider\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * @codeCoverageIgnore
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181014131105 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE virtual_users ADD CONSTRAINT FK_3C68956A115F0EE5 FOREIGN KEY (domain_id) REFERENCES virtual_domains (id)');
        $this->addSql('ALTER TABLE virtual_aliases ADD CONSTRAINT FK_696568F6115F0EE5 FOREIGN KEY (domain_id) REFERENCES virtual_domains (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE virtual_aliases DROP FOREIGN KEY FK_696568F6115F0EE5');
        $this->addSql('ALTER TABLE virtual_users DROP FOREIGN KEY FK_3C68956A115F0EE5');
    }
}
