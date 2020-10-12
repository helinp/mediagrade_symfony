<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910153612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, motto VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, skills_group_id INT NOT NULL, short_name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, transverse_skill LONGTEXT DEFAULT NULL, INDEX IDX_5E3DE477D6044424 (skills_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE self_assessment_question (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, question LONGTEXT NOT NULL, INDEX IDX_4BB1C5EB41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grading_system (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE criterion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(512) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, classe_id INT NOT NULL, teacher_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_169E6FB98F5EA509 (classe_id), INDEX IDX_169E6FB941807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, teacher_id INT NOT NULL, assessment_type_id INT NOT NULL, school_year VARCHAR(9) NOT NULL, instructions LONGTEXT DEFAULT NULL, start_date DATE NOT NULL, hard_deadline DATE NOT NULL, soft_deadline DATE DEFAULT NULL, name VARCHAR(255) NOT NULL, activated TINYINT(1) NOT NULL, external TINYINT(1) NOT NULL, context LONGTEXT NOT NULL, INDEX IDX_2FB3D0EE591CC992 (course_id), INDEX IDX_2FB3D0EE41807E1D (teacher_id), INDEX IDX_2FB3D0EE6FB21D5D (assessment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_self_assessment_question (project_id INT NOT NULL, self_assessment_question_id INT NOT NULL, INDEX IDX_DFCAB2A3166D1F9C (project_id), INDEX IDX_DFCAB2A3C91D5A2B (self_assessment_question_id), PRIMARY KEY(project_id, self_assessment_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_skill (project_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_4D68EDE9166D1F9C (project_id), INDEX IDX_4D68EDE95585C142 (skill_id), PRIMARY KEY(project_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment (id INT AUTO_INCREMENT NOT NULL, skill_id INT NOT NULL, criterion_id INT NOT NULL, project_id INT NOT NULL, indicator VARCHAR(255) NOT NULL, max_vote SMALLINT NOT NULL, INDEX IDX_F7523D705585C142 (skill_id), INDEX IDX_F7523D7097766307 (criterion_id), INDEX IDX_F7523D70166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477D6044424 FOREIGN KEY (skills_group_id) REFERENCES skills_group (id)');
        $this->addSql('ALTER TABLE self_assessment_question ADD CONSTRAINT FK_4BB1C5EB41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB98F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB941807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE6FB21D5D FOREIGN KEY (assessment_type_id) REFERENCES assessment_type (id)');
        $this->addSql('ALTER TABLE project_self_assessment_question ADD CONSTRAINT FK_DFCAB2A3166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_self_assessment_question ADD CONSTRAINT FK_DFCAB2A3C91D5A2B FOREIGN KEY (self_assessment_question_id) REFERENCES self_assessment_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_skill ADD CONSTRAINT FK_4D68EDE9166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_skill ADD CONSTRAINT FK_4D68EDE95585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D705585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D7097766307 FOREIGN KEY (criterion_id) REFERENCES criterion (id)');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D70166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE6FB21D5D');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB98F5EA509');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE591CC992');
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D7097766307');
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D70166D1F9C');
        $this->addSql('ALTER TABLE project_skill DROP FOREIGN KEY FK_4D68EDE9166D1F9C');
        $this->addSql('ALTER TABLE project_self_assessment_question DROP FOREIGN KEY FK_DFCAB2A3166D1F9C');
        $this->addSql('ALTER TABLE project_self_assessment_question DROP FOREIGN KEY FK_DFCAB2A3C91D5A2B');
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D705585C142');
        $this->addSql('ALTER TABLE project_skill DROP FOREIGN KEY FK_4D68EDE95585C142');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477D6044424');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB941807E1D');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE41807E1D');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113CB944F1A');
        $this->addSql('ALTER TABLE self_assessment_question DROP FOREIGN KEY FK_4BB1C5EB41807E1D');
        $this->addSql('DROP TABLE assessment');
        $this->addSql('DROP TABLE assessment_type');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE criterion');
        $this->addSql('DROP TABLE grading_system');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_skill');
        $this->addSql('DROP TABLE project_self_assessment_question');
        $this->addSql('DROP TABLE result');
        $this->addSql('DROP TABLE self_assessment_question');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skills_group');
        $this->addSql('DROP TABLE user');
    }
}
