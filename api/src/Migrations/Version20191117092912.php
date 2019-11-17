<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191117092912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            INSERT INTO `lensvision`.`lense_option` (`type`, `value`) VALUES 
            ('A', 'A - 1'),
            ('A', 'A - 2'),
            ('A', 'A - 3'),
            ('A', 'A - 4'),
            ('B', 'B - 1'),
            ('B', 'B - 2'),
            ('B', 'B - 3'),
            ('C', 'C - 1'),
            ('X', 'X - 1'),
            ('X', 'X - 2'),
            ('Y', 'Y - 1'),
            ('Y', 'Y - 2'),
            ('Y', 'Y - 3'),
            ('Z', 'Z - 1'),
            ('Z', 'Z - 2'),
            ('Z', 'Z - 3'),
            ('Z', 'Z - 4'),
            ('Z', 'Z - 5')
          ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
