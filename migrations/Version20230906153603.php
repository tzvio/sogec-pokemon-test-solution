<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906153603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type1 VARCHAR(255) DEFAULT NULL, type2 VARCHAR(255) DEFAULT NULL, total SMALLINT NOT NULL, hp SMALLINT NOT NULL, attack SMALLINT NOT NULL, defense SMALLINT NOT NULL, spatk SMALLINT NOT NULL, spdef SMALLINT NOT NULL, speed SMALLINT NOT NULL, generation SMALLINT NOT NULL, legendary BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pokemon');
    }
}
