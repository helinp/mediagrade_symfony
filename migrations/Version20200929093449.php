<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200929093449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance_grid (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, course_id INT DEFAULT NULL, date_time DATETIME NOT NULL, school_hour SMALLINT NOT NULL, INDEX IDX_16FE044241807E1D (teacher_id), INDEX IDX_16FE0442591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance_grid ADD CONSTRAINT FK_16FE044241807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE attendance_grid ADD CONSTRAINT FK_16FE0442591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91591CC992');
        $this->addSql('DROP INDEX IDX_6DE30D91591CC992 ON attendance');
        $this->addSql('ALTER TABLE attendance DROP school_year, DROP datetime, DROP school_hour, CHANGE course_id attendance_grid_id INT NOT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D912B368697 FOREIGN KEY (attendance_grid_id) REFERENCES attendance_grid (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D912B368697 ON attendance (attendance_grid_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D912B368697');
        $this->addSql('DROP TABLE attendance_grid');
        $this->addSql('DROP INDEX IDX_6DE30D912B368697 ON attendance');
        $this->addSql('ALTER TABLE attendance ADD school_year VARCHAR(9) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD datetime DATETIME NOT NULL, ADD school_hour SMALLINT NOT NULL, CHANGE attendance_grid_id course_id INT NOT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91591CC992 ON attendance (course_id)');
        $this->addSql('ALTER TABLE submission_file CHANGE public public TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
