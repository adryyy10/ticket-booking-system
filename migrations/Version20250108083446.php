<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108083446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ticket entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, event_id_id INTEGER NOT NULL, booking_id_id INTEGER DEFAULT NULL, seat INTEGER NOT NULL, CONSTRAINT FK_97A0ADA33E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_97A0ADA3EE3863E2 FOREIGN KEY (booking_id_id) REFERENCES booking (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_97A0ADA33E5F2F7B ON ticket (event_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3EE3863E2 ON ticket (booking_id_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE ticket');
    }
}
