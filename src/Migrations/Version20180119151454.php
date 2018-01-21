<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180119151454 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE category ADD COLUMN description CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_C5E24E1812469DE2');
        $this->addSql('DROP INDEX IDX_C5E24E187294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_article AS SELECT category_id, article_id FROM category_article');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('CREATE TABLE category_article (category_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(category_id, article_id), CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_article (category_id, article_id) SELECT category_id, article_id FROM __temp__category_article');
        $this->addSql('DROP TABLE __temp__category_article');
        $this->addSql('CREATE INDEX IDX_C5E24E1812469DE2 ON category_article (category_id)');
        $this->addSql('CREATE INDEX IDX_C5E24E187294869C ON category_article (article_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name, image, updated_at FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO category (id, name, image, updated_at) SELECT id, name, image, updated_at FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('DROP INDEX IDX_C5E24E1812469DE2');
        $this->addSql('DROP INDEX IDX_C5E24E187294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_article AS SELECT category_id, article_id FROM category_article');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('CREATE TABLE category_article (category_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(category_id, article_id))');
        $this->addSql('INSERT INTO category_article (category_id, article_id) SELECT category_id, article_id FROM __temp__category_article');
        $this->addSql('DROP TABLE __temp__category_article');
        $this->addSql('CREATE INDEX IDX_C5E24E1812469DE2 ON category_article (category_id)');
        $this->addSql('CREATE INDEX IDX_C5E24E187294869C ON category_article (article_id)');
    }
}
