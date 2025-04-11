<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410062457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE conv DROP FOREIGN KEY FK_94499CC1DA67974');
        $this->addSql('ALTER TABLE conv DROP FOREIGN KEY FK_94499CC537A1329');
        $this->addSql('DROP INDEX IDX_94499CC1DA67974 ON conv');
        $this->addSql('DROP INDEX IDX_94499CC537A1329 ON conv');
        $this->addSql('ALTER TABLE conv DROP conv_user_id, DROP message_id');
        $this->addSql('ALTER TABLE conv_user ADD users_id INT DEFAULT NULL, ADD convs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conv_user ADD CONSTRAINT FK_9A4A93F367B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE conv_user ADD CONSTRAINT FK_9A4A93F3E25E2C28 FOREIGN KEY (convs_id) REFERENCES conv (id)');
        $this->addSql('CREATE INDEX IDX_9A4A93F367B3B43D ON conv_user (users_id)');
        $this->addSql('CREATE INDEX IDX_9A4A93F3E25E2C28 ON conv_user (convs_id)');
        $this->addSql('ALTER TABLE message ADD convs_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE25E2C28 FOREIGN KEY (convs_id) REFERENCES conv (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE25E2C28 ON message (convs_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DA67974');
        $this->addSql('DROP INDEX IDX_8D93D6491DA67974 ON user');
        $this->addSql('ALTER TABLE user DROP conv_user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conv ADD conv_user_id INT DEFAULT NULL, ADD message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conv ADD CONSTRAINT FK_94499CC1DA67974 FOREIGN KEY (conv_user_id) REFERENCES conv_user (id)');
        $this->addSql('ALTER TABLE conv ADD CONSTRAINT FK_94499CC537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('CREATE INDEX IDX_94499CC1DA67974 ON conv (conv_user_id)');
        $this->addSql('CREATE INDEX IDX_94499CC537A1329 ON conv (message_id)');
        $this->addSql('ALTER TABLE user ADD conv_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DA67974 FOREIGN KEY (conv_user_id) REFERENCES conv_user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6491DA67974 ON user (conv_user_id)');
        $this->addSql('ALTER TABLE conv_user DROP FOREIGN KEY FK_9A4A93F367B3B43D');
        $this->addSql('ALTER TABLE conv_user DROP FOREIGN KEY FK_9A4A93F3E25E2C28');
        $this->addSql('DROP INDEX IDX_9A4A93F367B3B43D ON conv_user');
        $this->addSql('DROP INDEX IDX_9A4A93F3E25E2C28 ON conv_user');
        $this->addSql('ALTER TABLE conv_user DROP users_id, DROP convs_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE25E2C28');
        $this->addSql('DROP INDEX IDX_B6BD307FE25E2C28 ON message');
        $this->addSql('ALTER TABLE message DROP convs_id');
    }
}
