<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260609092317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_catagory (article_id INT NOT NULL, catagory_id INT NOT NULL, INDEX IDX_A6244B6A7294869C (article_id), INDEX IDX_A6244B6A960C9318 (catagory_id), PRIMARY KEY (article_id, catagory_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE article_catagory ADD CONSTRAINT FK_A6244B6A7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_catagory ADD CONSTRAINT FK_A6244B6A960C9318 FOREIGN KEY (catagory_id) REFERENCES catagory (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_catagory DROP FOREIGN KEY FK_A6244B6A7294869C');
        $this->addSql('ALTER TABLE article_catagory DROP FOREIGN KEY FK_A6244B6A960C9318');
        $this->addSql('DROP TABLE article_catagory');
    }
}
