<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180120133142 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_64C19C1989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name, image, updated_at, description, slug FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, description CLOB DEFAULT NULL COLLATE BINARY, slug VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO category (id, name, image, updated_at, description, slug) SELECT id, name, image, updated_at, description, slug FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('DROP INDEX IDX_C5E24E1812469DE2');
        $this->addSql('DROP INDEX IDX_C5E24E187294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_article AS SELECT category_id, article_id FROM category_article');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('CREATE TABLE category_article (category_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(category_id, article_id), CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_article (category_id, article_id) SELECT category_id, article_id FROM __temp__category_article');
        $this->addSql('DROP TABLE __temp__category_article');
        $this->addSql('CREATE INDEX IDX_C5E24E1812469DE2 ON category_article (category_id)');
        $this->addSql('CREATE INDEX IDX_C5E24E187294869C ON category_article (article_id)');
        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, short_text, text, image, updated_at, slug FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, title VARCHAR(100) NOT NULL COLLATE BINARY, short_text CLOB NOT NULL COLLATE BINARY, text CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, updated_at DATETIME DEFAULT NULL, slug VARCHAR(128) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO article (id, title, short_text, text, image, updated_at, slug) SELECT id, title, short_text, text, image, updated_at, slug FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, slug, short_text, text, image, updated_at FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, short_text CLOB NOT NULL, text CLOB NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(128) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO article (id, title, slug, short_text, text, image, updated_at) SELECT id, title, slug, short_text, text, image, updated_at FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
        $this->addSql('DROP INDEX UNIQ_64C19C1989D9B62');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, name, slug, description, image, updated_at FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER NOT NULL, name VARCHAR(100) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(128) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO category (id, name, slug, description, image, updated_at) SELECT id, name, slug, description, image, updated_at FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
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
