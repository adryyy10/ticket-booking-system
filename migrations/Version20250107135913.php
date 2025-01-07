<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250107135913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Booking table + relations';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id_id INTEGER NOT NULL, event_id_id INTEGER NOT NULL, num_tickets INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_E00CEDDE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDE3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE9D86650F ON booking (user_id_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3E5F2F7B ON booking (event_id_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE booking');
    }
}
