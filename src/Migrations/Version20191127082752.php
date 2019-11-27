<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191127082752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE property RENAME INDEX idx_8bf21cdef7bfe87c TO IDX_8BF21CDE5DC6FE57');
        $this->addSql('ALTER TABLE sub_category RENAME INDEX uniq_bce3f79812469de2 TO IDX_BCE3F79812469DE2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP updated_at');
        $this->addSql('ALTER TABLE property RENAME INDEX idx_8bf21cde5dc6fe57 TO IDX_8BF21CDEF7BFE87C');
        $this->addSql('ALTER TABLE sub_category RENAME INDEX idx_bce3f79812469de2 TO UNIQ_BCE3F79812469DE2');
    }
}
