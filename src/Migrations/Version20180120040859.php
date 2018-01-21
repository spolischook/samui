<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180120040859 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_C5E24E1812469DE2');
        $this->addSql('DROP INDEX IDX_C5E24E187294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__category_article AS SELECT category_id, article_id FROM category_article');
        $this->addSql('DROP TABLE category_article');
        $this->addSql('CREATE TABLE category_article (category_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(category_id, article_id), CONSTRAINT FK_C5E24E1812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C5E24E187294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO category_article (category_id, article_id) SELECT category_id, article_id FROM __temp__category_article');
        $this->addSql('DROP TABLE __temp__category_article');
        $this->addSql('CREATE INDEX IDX_C5E24E1812469DE2 ON category_article (category_id)');
        $this->addSql('CREATE INDEX IDX_C5E24E187294869C ON category_article (article_id)');
        $this->addSql('ALTER TABLE article ADD COLUMN image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD COLUMN updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, title, short_text, text FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, short_text CLOB NOT NULL, text CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO article (id, title, short_text, text) SELECT id, title, short_text, text FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
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
