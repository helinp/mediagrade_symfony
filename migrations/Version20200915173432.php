<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915173432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, project_id INT NOT NULL, datetime DATETIME NOT NULL, INDEX IDX_DB055AF3CB944F1A (student_id), INDEX IDX_DB055AF3166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE self_assessment_answer (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, project_id INT NOT NULL, answer LONGTEXT DEFAULT NULL, datetime DATETIME NOT NULL, INDEX IDX_1BA1F6D6CB944F1A (student_id), INDEX IDX_1BA1F6D6166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE self_assessment_answer ADD CONSTRAINT FK_1BA1F6D6CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE self_assessment_answer ADD CONSTRAINT FK_1BA1F6D6166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE self_assessment_answer');
        $this->addSql('DROP TABLE submission');
    }
}
