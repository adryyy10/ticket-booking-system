<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109092104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'booked field in ticket';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ticket ADD COLUMN booked BOOLEAN NOT NULL DEFAULT FALSE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE ticket DROP COLUMN booked');
    }
}
