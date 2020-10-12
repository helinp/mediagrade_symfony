<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910161701 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assessment ADD grading_system_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D70E383D86E FOREIGN KEY (grading_system_id) REFERENCES grading_system (id)');
        $this->addSql('CREATE INDEX IDX_F7523D70E383D86E ON assessment (grading_system_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D70E383D86E');
        $this->addSql('DROP INDEX IDX_F7523D70E383D86E ON assessment');
        $this->addSql('ALTER TABLE assessment DROP grading_system_id');
    }
}
