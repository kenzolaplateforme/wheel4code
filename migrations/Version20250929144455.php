<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929144455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE draw DROP FOREIGN KEY FK_70F2BD0F67B3B43D');
        $this->addSql('DROP INDEX IDX_70F2BD0F67B3B43D ON draw');
        $this->addSql('ALTER TABLE draw DROP users_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE draw ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE draw ADD CONSTRAINT FK_70F2BD0F67B3B43D FOREIGN KEY (users_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_70F2BD0F67B3B43D ON draw (users_id)');
    }
}
