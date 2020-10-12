<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200929155551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
      //  $this->addSql('ALTER TABLE attendance ADD is_present TINYINT(1) DEFAULT NULL, ADD is_absent TINYINT(1) DEFAULT NULL, ADD is_late TINYINT(1) DEFAULT NULL, ADD is_excused TINYINT(1) DEFAULT NULL, DROP status');
      //  $this->addSql('ALTER TABLE submission_file CHANGE public public TINYINT(1) DEFAULT NULL');
      //  $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance ADD status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP is_present, DROP is_absent, DROP is_late, DROP is_excused');
        $this->addSql('ALTER TABLE submission_file CHANGE public public TINYINT(1) DEFAULT \'1\'');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
