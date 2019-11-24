<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191124124321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, sub_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_64C19C1F7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX IDX_BCE3F79812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, username_id INT NOT NULL, category_id INT NOT NULL, sub_category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, city VARCHAR(255) NOT NULL, sold TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8BF21CDEED766068 (username_id), INDEX IDX_8BF21CDE12469DE2 (category_id), INDEX IDX_8BF21CDEF7BFE87C (sub_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(64) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1F7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F79812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEED766068 FOREIGN KEY (username_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEF7BFE87C FOREIGN KEY (sub_category_id) REFERENCES sub_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sub_category DROP FOREIGN KEY FK_BCE3F79812469DE2');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE12469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1F7BFE87C');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEF7BFE87C');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEED766068');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE user');
    }
}
