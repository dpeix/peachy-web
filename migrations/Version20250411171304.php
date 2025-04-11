<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250411171304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD convs_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE25E2C28 FOREIGN KEY (convs_id) REFERENCES conv (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B6BD307FE25E2C28 ON message (convs_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D6491DA67974
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8D93D6491DA67974 ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP conv_user_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE25E2C28
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B6BD307FE25E2C28 ON message
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message DROP convs_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD conv_user_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D6491DA67974 FOREIGN KEY (conv_user_id) REFERENCES conv_user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8D93D6491DA67974 ON user (conv_user_id)
        SQL);
    }
}
