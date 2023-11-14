<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231026120418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games_category (games_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_AF4B7EFD97FFC673 (games_id), INDEX IDX_AF4B7EFD12469DE2 (category_id), PRIMARY KEY(games_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE games_category ADD CONSTRAINT FK_AF4B7EFD97FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_category ADD CONSTRAINT FK_AF4B7EFD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE console ADD logo_name VARCHAR(255) NOT NULL, ADD console_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE games_category DROP FOREIGN KEY FK_AF4B7EFD97FFC673');
        $this->addSql('ALTER TABLE games_category DROP FOREIGN KEY FK_AF4B7EFD12469DE2');
        $this->addSql('DROP TABLE games_category');
        $this->addSql('ALTER TABLE console DROP logo_name, DROP console_name');
    }
}
