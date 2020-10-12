<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200929100329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D9141807E1D');
        $this->addSql('DROP INDEX IDX_6DE30D9141807E1D ON attendance');
        $this->addSql('ALTER TABLE attendance DROP teacher_id');
       // $this->addSql('ALTER TABLE submission_file CHANGE public public TINYINT(1) DEFAULT NULL');
       // $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance ADD teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D9141807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D9141807E1D ON attendance (teacher_id)');
        $this->addSql('ALTER TABLE submission_file CHANGE public public TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
