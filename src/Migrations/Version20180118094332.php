<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180118094332 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_300B23CC7294869C');
        $this->addSql('DROP INDEX IDX_300B23CCBAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_article AS SELECT tag_id, article_id FROM tag_article');
        $this->addSql('DROP TABLE tag_article');
        $this->addSql('CREATE TABLE tag_article (tag_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(tag_id, article_id), CONSTRAINT FK_300B23CCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_300B23CC7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO tag_article (tag_id, article_id) SELECT tag_id, article_id FROM __temp__tag_article');
        $this->addSql('DROP TABLE __temp__tag_article');
        $this->addSql('CREATE INDEX IDX_300B23CC7294869C ON tag_article (article_id)');
        $this->addSql('CREATE INDEX IDX_300B23CCBAD26311 ON tag_article (tag_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_300B23CCBAD26311');
        $this->addSql('DROP INDEX IDX_300B23CC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag_article AS SELECT tag_id, article_id FROM tag_article');
        $this->addSql('DROP TABLE tag_article');
        $this->addSql('CREATE TABLE tag_article (tag_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(tag_id, article_id))');
        $this->addSql('INSERT INTO tag_article (tag_id, article_id) SELECT tag_id, article_id FROM __temp__tag_article');
        $this->addSql('DROP TABLE __temp__tag_article');
        $this->addSql('CREATE INDEX IDX_300B23CCBAD26311 ON tag_article (tag_id)');
        $this->addSql('CREATE INDEX IDX_300B23CC7294869C ON tag_article (article_id)');
    }
}
