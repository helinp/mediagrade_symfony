<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200910160905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Achievements';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achievement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(512) NOT NULL, number_of_stars SMALLINT NOT NULL, icon_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_achievement (user_id INT NOT NULL, achievement_id INT NOT NULL, INDEX IDX_3F68B664A76ED395 (user_id), INDEX IDX_3F68B664B3EC99FE (achievement_id), PRIMARY KEY(user_id, achievement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_achievement ADD CONSTRAINT FK_3F68B664A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_achievement ADD CONSTRAINT FK_3F68B664B3EC99FE FOREIGN KEY (achievement_id) REFERENCES achievement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment ADD achievement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D70B3EC99FE FOREIGN KEY (achievement_id) REFERENCES achievement (id)');
        $this->addSql('CREATE INDEX IDX_F7523D70B3EC99FE ON assessment (achievement_id)');
        $this->addSql('ALTER TABLE user ADD avatar_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D70B3EC99FE');
        $this->addSql('ALTER TABLE user_achievement DROP FOREIGN KEY FK_3F68B664B3EC99FE');
        $this->addSql('DROP TABLE achievement');
        $this->addSql('DROP TABLE user_achievement');
        $this->addSql('DROP INDEX IDX_F7523D70B3EC99FE ON assessment');
        $this->addSql('ALTER TABLE assessment DROP achievement_id');
        $this->addSql('ALTER TABLE user DROP avatar_url');
    }
}
