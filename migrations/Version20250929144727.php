<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929144727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE draw_user (draw_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2481798C6FC5C1B8 (draw_id), INDEX IDX_2481798CA76ED395 (user_id), PRIMARY KEY(draw_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE draw_user ADD CONSTRAINT FK_2481798C6FC5C1B8 FOREIGN KEY (draw_id) REFERENCES draw (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE draw_user ADD CONSTRAINT FK_2481798CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE draw_user DROP FOREIGN KEY FK_2481798C6FC5C1B8');
        $this->addSql('ALTER TABLE draw_user DROP FOREIGN KEY FK_2481798CA76ED395');
        $this->addSql('DROP TABLE draw_user');
    }
}
