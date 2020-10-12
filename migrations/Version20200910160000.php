<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910160000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Not sure of these fields';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD file_extension VARCHAR(10) DEFAULT NULL, ADD number_of_files SMALLINT NOT NULL, ADD teacher_submitted TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP file_extension, DROP number_of_files, DROP teacher_submitted');
    }
}
