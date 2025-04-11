<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250408094349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conv (id INT AUTO_INCREMENT NOT NULL, conv_user_id INT DEFAULT NULL, message_id INT DEFAULT NULL, date_last_message DATETIME DEFAULT NULL, INDEX IDX_94499CC1DA67974 (conv_user_id), INDEX IDX_94499CC537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conv_user (id INT AUTO_INCREMENT NOT NULL, date_last_check DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL, date_post DATETIME NOT NULL, body VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conv ADD CONSTRAINT FK_94499CC1DA67974 FOREIGN KEY (conv_user_id) REFERENCES conv_user (id)');
        $this->addSql('ALTER TABLE conv ADD CONSTRAINT FK_94499CC537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE user ADD conv_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DA67974 FOREIGN KEY (conv_user_id) REFERENCES conv_user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491DA67974 ON user (conv_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DA67974');
        $this->addSql('ALTER TABLE conv DROP FOREIGN KEY FK_94499CC1DA67974');
        $this->addSql('ALTER TABLE conv DROP FOREIGN KEY FK_94499CC537A1329');
        $this->addSql('DROP TABLE conv');
        $this->addSql('DROP TABLE conv_user');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP INDEX IDX_8D93D6491DA67974 ON user');
        $this->addSql('ALTER TABLE user DROP conv_user_id');
    }
}
