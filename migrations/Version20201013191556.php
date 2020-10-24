<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013191556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE self_assessment_answer ADD self_assessment_question_id INT NOT NULL');
        $this->addSql('ALTER TABLE self_assessment_answer ADD CONSTRAINT FK_1BA1F6D6C91D5A2B FOREIGN KEY (self_assessment_question_id) REFERENCES self_assessment_question (id)');
        $this->addSql('CREATE INDEX IDX_1BA1F6D6C91D5A2B ON self_assessment_answer (self_assessment_question_id)');
     //   $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE self_assessment_answer DROP FOREIGN KEY FK_1BA1F6D6C91D5A2B');
        $this->addSql('DROP INDEX IDX_1BA1F6D6C91D5A2B ON self_assessment_answer');
        $this->addSql('ALTER TABLE self_assessment_answer DROP self_assessment_question_id');
     //   $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
